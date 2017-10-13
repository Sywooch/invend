<?php

namespace app\controllers;

use Yii;
use app\models\Vendor;
use app\models\Po;
use app\models\Stock;
use app\models\Transactions;
use app\models\PoSearch;
use app\models\PoLines;
use app\models\PoLinesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DynamicForms;
use yii\helpers\ArrayHelper;
use app\widgets\GeneratePassword;

/**
 * PoController implements the CRUD actions for Po model.
 */
class PoController extends Controller
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
        $searchModel = new PoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Po model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new PoLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('po_id = :field1', [':field1' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelPoLines' => $this->findModelPoLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'empty';
        $searchModel = new PoLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('po_id = :field1', [':field1' => $id]);

        return $this->render('print', [
            'model' => $this->findModel($id),
            'modelPoLines' => $this->findModelPoLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Po model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelPo = new Po();
        $modelVendor = new Vendor();
        $modelStock = new Stock();
        $generate = new GeneratePassword();
        $modelTransactions = new Transactions();
        $modelsPoLines = [new PoLines()];

        if ($modelPo->load(Yii::$app->request->post())) {

            // get PoLines data from POST
            $modelsPoLines = DynamicForms::createMultiple(PoLines::classname());
            DynamicForms::loadMultiple($modelsPoLines, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPoLines),
                    ActiveForm::validate($modelPo)
                );
            }

            // validate all models - see example online for ajax validation
            $valid = $modelPo->validate();
            $valid = PoLines::validatePo($modelsPoLines) && $valid;

            // $valid = true;

            // save po data
            if ($valid) {
                $modelPo->reason = 1;
                
                if ($this->savePo($generate,$modelTransactions,$modelStock,$modelPo,$modelsPoLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The purchase order number {id} has been saved.', ['id' => $modelPo->id]));
                    return $this->redirect('index');
                }
            }
        }

        return $this->render('create', [
            'modelPo' => $modelPo,
            'modelVendor' => $modelVendor,
            'modelsPoLines'  => (empty($modelsPoLines)) ? [new PoLines] : $modelsPoLines,
        ]);
    }

    /**
     * Updates an existing Po model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // retrieve existing product data
        $modelPo = $this->findModel($id);
        $modelVendor = new Vendor();
        $modelStock = new Stock();
        $generate = new GeneratePassword();
        $modelTransactions = new Transactions();

        // retrieve existing polines data
        $oldPoLineIds = PoLines::find()->select('id')
            ->where(['po_id' => $id])->asArray()->all();
        $oldPoLineIds = ArrayHelper::getColumn($oldPoLineIds,'id');
        $modelsPoLines = PoLines::findAll(['id' => $oldPoLineIds]);
        $modelsPoLines = (empty($modelsPoLines)) ? [new PoLines] : $modelsPoLines;

        $modelPo->count = PoLines::find()->select('id')
            ->where(['po_id' => $id])->count();

        // handle POST
        if ($modelPo->load(Yii::$app->request->post())) {

            // get stock data from POST
            $modelsPoLines = DynamicForms::createMultiple(PoLines::classname(), $modelsPoLines);
            DynamicForms::loadMultiple($modelsPoLines, Yii::$app->request->post());
            $newPoLineIds = ArrayHelper::getColumn($modelsPoLines,'id');

            // delete removed data
            $delPoLineIds = array_diff($oldPoLineIds,$newPoLineIds);
            if (! empty($delPoLineIds)) PoLines::deleteAll(['id' => $delPoLineIds]);

            // validate all models
            $valid = $modelPo->validate();
            $valid = PoLines::validatePo($modelsPoLines) && $valid;

            // save po data
            if ($valid) {
                if ($this->savePo($generate,$modelTransactions,$modelStock,$modelPo,$modelsPoLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The purchase order number {id} has been saved.', ['id' => $modelPo->id]));
                    return $this->redirect('/po/index');
                }
            }
        }

        // show VIEW
        return $this->render('update', [
            'modelPo' => $modelPo,
            'modelVendor' => $modelVendor,
            'modelsPoLines'  => $modelsPoLines,

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
    protected function savePo($generate,$modelTransactions,$modelStock,$modelPo,$modelsPoLines) {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $modelPo->user_id = Yii::$app->user->getId();
            $modelPo->time = date('Y-m-d H:i:s');
            $modelPo->balance = $modelPo->total - $modelPo->paid;
            if(empty($modelPo->number))
                $modelPo->number = 'PO-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);

            if($modelPo->paid > 0)
            {
                // Received, Paid
                $modelPo->status = 2;
            }
            else {
                // Received, Unpaid
                $modelPo->status = 3;
            }
            if ($go = $modelPo->save(false)) {

                // Transactions

                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelPo->vendor->paymentMethod->name;
                $modelTransactions->remarks = "We purchased items from ". $modelPo->vendor->name. " at ".$modelPo->time." by ".$modelPo->user->username;
                $modelTransactions->debit = $modelPo->total;
                $modelTransactions->account = "purchases";
                $modelTransactions->credit = 0;

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                $modelTransactions = new Transactions;
                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelPo->vendor->paymentMethod->name;
                $modelTransactions->remarks = "We purchased items from ". $modelPo->vendor->name. " at ".$modelPo->time." by ".$modelPo->user->username;

                $modelTransactions->credit = $modelPo->total;
                $modelTransactions->account = "cash";
                $modelTransactions->debit = 0;
                
                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                // loop through each po_lines
                foreach ($modelsPoLines as $i => $modelPoLine) {
                    // save the po_lines record
                    if($modelPoLine->quantity > 0) {
                        $modelPoLine->active = true;
                        $modelPoLine->user_id = Yii::$app->user->getId();
                        $modelPoLine->time = date('Y-m-d H:i:s');
                        $modelPoLine->po_id = $modelPo->id;
                        $modelPoLine->item_name = $modelPoLine->product->item_name;
                        $modelPoLine->item_code = $modelPoLine->product->item_code;
                        $modelPoLine->sub_total = $modelPoLine->quantity * $modelPoLine->unit_price;
                        //$modelPoLine->sub_total = $modelPoLine->sub_total - ($modelPoLine->discount/100) * $modelPoLine->sub_total;

                        // Stock

                        $modelStock->active = true;
                        $modelStock->user_id = Yii::$app->user->getId();
                        $modelStock->time = date('Y-m-d H:i:s');
                        $modelStock->product_id = $modelPoLine->product_id;
                        $modelStock->quantity = $modelPoLine->quantity;
                        $modelStock->location_id = $modelPo->location_id;
                        $modelStock->product_category_id = $modelPoLine->product->product_category_id;

                        if($modelPoLine->product->last_vendor_id !== null){
                            $modelStock->last_vendor_id = $modelPoLine->product->last_vendor_id;
                        }

                        if (! ($go = $modelPoLine->save(false) && $modelStock->save(false))) {
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
     * Deletes an existing Po model.
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
     * Finds the Po model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Po the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Po::findOne($id)) !== null) {
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
    protected function findModelPoLines($id)
    {
        if (($modelPoLines = PoLines::find($id)) !== null) {
            return $modelPoLines;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
