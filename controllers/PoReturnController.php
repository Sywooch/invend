<?php

namespace app\controllers;

use Yii;
use app\models\PoReturn;
use app\models\PoReturnLines;
use app\models\PoReturnLinesSearch;
use app\models\Vendor;
use app\models\Stock;
use app\models\Transactions;
use app\models\PoReturnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DynamicForms;
use yii\helpers\ArrayHelper;
use app\widgets\GeneratePassword;

/**
 * PoReturnController implements the CRUD actions for PoReturn model.
 */
class PoReturnController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Po models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PoReturnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PoReturn model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new PoReturnLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('po_return_id = :field1', [':field1' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelPoReturnLines' => $this->findModelPoReturnLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'empty'; 
        $searchModel = new PoReturnLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('po_return_id = :field1', [':field1' => $id]);

        return $this->render('print', [
            'model' => $this->findModel($id),
            'modelPoLines' => $this->findModelPoReturnLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Creates a new PoReturn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelPoReturn = new PoReturn();
        $modelVendor = new Vendor();
        $modelsPoReturnLines = [new PoReturnLines()];
        $modelStock = new Stock();
        $modelTransactions = new Transactions();
        $generate = new GeneratePassword();

        if ($modelPoReturn->load(Yii::$app->request->post())) {

            // get PoReturnLines data from POST
            $modelsPoReturnLines = DynamicForms::createMultiple(PoReturnLines::classname());
            DynamicForms::loadMultiple($modelsPoReturnLines, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPoReturnLines),
                    ActiveForm::validate($modelPoReturn)
                );
            }

            // validate all models - see example online for ajax validation
            $valid = $modelPoReturn->validate();
            $valid = PoReturnLines::validatePoReturn($modelsPoReturnLines) && $valid;

            // save po return data
            if ($valid) {
                $modelPoReturn->reason = 2;
                if ($this->savePoReturn($generate,$modelTransactions,$modelStock,$modelPoReturn,$modelsPoReturnLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The purchase order return number {id} has been saved.', ['id' => $modelPoReturn->id]));
                    return $this->redirect('index');
                }
            }
        }

        return $this->render('create', [
            'modelPoReturn' => $modelPoReturn,
            'modelVendor' => $modelVendor,
            'modelsPoReturnLines'  => (empty($modelsPoReturnLines)) ? [new PoLines] : $modelsPoReturnLines,
        ]);
    }

    /**
     * Updates an existing PoReturn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // retrieve existing po_return data
        $modelPoReturn = $this->findModel($id);
        $modelVendor = new Vendor();
        $modelStock = new Stock();
        $modelTransactions = new Transactions();
        $generate = new GeneratePassword();

        // retrieve existing po_return_lines data
        $oldPoReturnLineIds = PoReturnLines::find()->select('id')
            ->where(['po_return_id' => $id])->asArray()->all();
        $oldPoReturnLineIds = ArrayHelper::getColumn($oldPoReturnLineIds,'id');
        $modelsPoReturnLines = PoReturnLines::findAll(['id' => $oldPoReturnLineIds]);
        $modelsPoReturnLines = (empty($modelsPoReturnLines)) ? [new PoReturnLines] : $modelsPoReturnLines;

        $modelPoReturn->count = PoReturnLines::find()->select('id')
            ->where(['po_return_id' => $id])->count();

        // handle POST
        if ($modelPoReturn->load(Yii::$app->request->post())) {

            // get stock data from POST
            $modelsPoReturnLines = DynamicForms::createMultiple(PoReturnLines::classname(), $modelsPoReturnLines);
            DynamicForms::loadMultiple($modelsPoReturnLines, Yii::$app->request->post());
            $newPoReturnLineIds = ArrayHelper::getColumn($modelsPoReturnLines,'id');

            // delete removed data
            $delPoLineIds = array_diff($oldPoReturnLineIds,$newPoReturnLineIds);
            if (! empty($delPoReturnLineIds)) PoReturnLines::deleteAll(['id' => $delPoReturnLineIds]);

            // validate all models
            $valid = $modelPoReturn->validate();
            $valid = PoReturnLines::validatePoReturn($modelsPoReturnLines) && $valid;

            // save po data
            if ($valid) {
                if ($this->savePoReturn($generate,$modelTransactions,$modelStock,$modelPoReturn,$modelsPoReturnLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The purchase order return number {id} has been saved.', ['id' => $modelPoReturn->id]));
                    return $this->redirect('/po-return/index');
                }
            }
        }

        // show VIEW
        return $this->render('update', [
            'modelPoReturn' => $modelPoReturn,
            'modelVendor' => $modelVendor,
            'modelsPoReturnLines'  => $modelsPoReturnLines,

        ]);
    }

    /**
     * This function saves each part of the product dynamic form controls.
     *
     * @param $modelProduct mixed The product model.
     * @param $modelsStock mixed The stock model from the product.
     * @return bool Returns TRUE if successful.
     * @throws NotFoundHttpException When record cannot be saved.
     */
    protected function savePoReturn($generate,$modelTransactions,$modelStock,$modelPoReturn,$modelsPoReturnLines) {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $modelPoReturn->user_id = Yii::$app->user->getId();
            $modelPoReturn->time = date('Y-m-d H:i:s');
            $modelPoReturn->total =  -1 * abs($modelPoReturn->total);
            $modelPoReturn->paid =  -1 * abs($modelPoReturn->paid);
            $modelPoReturn->balance = $modelPoReturn->total - $modelPoReturn->paid;

            if(empty($modelPoReturn->number))
                $modelPoReturn->number = 'POR-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);

            if($modelPoReturn->paid > 0)
            {
                // Returned, Paid
                $modelPoReturn->status = 5;
            }
            else {
                // Returned, Unpaid
                $modelPoReturn->status = 6;
            }
            if ($go = $modelPoReturn->save(false)) {

                // Transactions

                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelPoReturn->vendor->paymentMethod->name;
                $modelTransactions->remarks = "We return purchased items to ". $modelPoReturn->vendor->name. "at ".$modelPoReturn->time." by ".$modelPoReturn->user->username;

                if($modelTransactions->type === "Cash"){
                    $modelTransactions->credit = $modelPoReturn->paid;
                    $modelTransactions->account = "cash";

                    $modelTransactions->debit = $modelPoReturn->paid;
                    $modelTransactions->account = "sales";
                }else{
                    $modelTransactions->credit = $modelPoReturn->paid;
                    $modelTransactions->account = "account payable";

                    $modelTransactions->debit = $modelPoReturn->paid;
                    $modelTransactions->account = "sales";
                }
                

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                // loop through each po__return_lines
                foreach ($modelsPoReturnLines as $i => $modelPoReturnLine) {
                    // save the po_lines record
                    if($modelPoReturnLine->quantity > 0) {
                        $modelPoReturnLine->active = true;
                        $modelPoReturnLine->user_id = Yii::$app->user->getId();
                        $modelPoReturnLine->time = date('Y-m-d H:i:s');
                        $modelPoReturnLine->po_return_id = $modelPoReturn->id;
                        $modelPoReturnLine->item_name = $modelPoReturnLine->product->item_name;
                        $modelPoReturnLine->item_code = $modelPoReturnLine->product->item_code;
                        $modelPoReturnLine->sub_total = $modelPoReturnLine->quantity * $modelPoReturnLine->unit_price;
                        //$modelPoReturnLine->sub_total = $modelPoReturnLine->sub_total - ($modelPoReturnLine->discount/100) * $modelPoReturnLine->sub_total;

                        // Stock

                        $modelStock->active = true;
                        $modelStock->user_id = Yii::$app->user->getId();
                        $modelStock->time = date('Y-m-d H:i:s');
                        $modelStock->product_id = $modelPoReturnLine->product_id;
                        $modelStock->quantity = -1 * abs($modelPoReturnLine->quantity);
                        $modelStock->location_id = $modelPoReturn->location_id;
                        $modelStock->product_category_id = $modelPoReturnLine->product->product_category_id;

                        if($modelPoReturnLine->product->last_vendor_id !== null){
                            $modelStock->last_vendor_id = $modelPoReturnLine->product->last_vendor_id;
                        }
                        
                        if (! ($go = $modelPoReturnLine->save(false) && $modelStock->save(false))) {
                            $transaction->rollBack();
                            break;
                        }

                        $modelStock =new Stock;
                    }
                }
            }
            if ($go) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return $go;
    }

    /**
     * Deletes an existing PoReturn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PoReturn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PoReturn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PoReturn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelPoReturnLines($id)
    {
        if (($modelPoReturnLines = PoReturnLines::find($id)) !== null) {
            return $modelPoReturnLines;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
