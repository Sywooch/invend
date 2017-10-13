<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\Stock;
use app\models\Transactions;
use app\models\SalesOrderReturn;
use app\models\SalesOrderReturnSearch;
use app\models\SalesOrderReturnLines;
use app\models\SalesOrderReturnLinesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DynamicForms;
use yii\helpers\ArrayHelper;
use app\widgets\GeneratePassword;

/**
 * SalesOrderReturnController implements the CRUD actions for SalesOrderReturn model.
 */
class SalesOrderReturnController extends Controller
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
     * Lists all SalesOrderReturn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesOrderReturnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesOrderReturn model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SalesOrderReturnLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('sales_order_return_id = :field1', [':field1' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelSalesOrderReturnLines' => $this->findModelSalesOrderReturnLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'empty';
        $searchModel = new SalesOrderReturnLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('sales_order_return_id = :field1', [':field1' => $id]);

        return $this->render('print', [
            'model' => $this->findModel($id),
            'modelSalesOrderReturnLines' => $this->findModelSalesOrderReturnLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SalesOrderReturn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelSalesOrderReturn = new SalesOrderReturn();
        $modelCustomer = new Customer();
        $modelStock = new Stock();
        $generate = new GeneratePassword();
        $modelTransactions = new Transactions();
        $modelsSalesOrderReturnLines = [new SalesOrderReturnLines()];

        if ($modelSalesOrderReturn->load(Yii::$app->request->post())) {

            // get SalesOrderReturnLines data from POST
            $modelsSalesOrderReturnLines = DynamicForms::createMultiple(SalesOrderReturnLines::classname());
            DynamicForms::loadMultiple($modelsSalesOrderReturnLines, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsSalesOrderReturnLines),
                    ActiveForm::validate($modelSalesOrderReturn)
                );
            }

            // validate all models - see example online for ajax validation
            $valid = $modelSalesOrderReturn->validate();
            $valid = SalesOrderReturnLines::validateSalesOrderReturn($modelsSalesOrderReturnLines) && $valid;

            // save sales_order data
            if ($valid) {
                $modelSalesOrderReturn->reason = 1;
                if ($this->saveSalesOrderReturn($generate,$modelTransactions,$modelStock,$modelSalesOrderReturn,$modelsSalesOrderReturnLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The sales order return number {id} has been saved.', ['id' => $modelSalesOrderReturn->id]));
                    return $this->redirect('index');
                }
            }
        }

        return $this->render('create', [
            'modelSalesOrderReturn' => $modelSalesOrderReturn,
            'modelCustomer' => $modelCustomer,
            'modelsSalesOrderReturnLines'  => (empty($modelsSalesOrderReturnLines)) ? [new SalesOrderReturnLines] : $modelsSalesOrderReturnLines,
        ]);
    }

    /**
     * Updates an existing SalesOrderReturn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // retrieve existing sales order data
        $modelSalesOrderReturn = $this->findModel($id);
        $modelCustomer = new Customer();
        $generate = new GeneratePassword();
        $modelStock = new Stock();
        $modelTransactions = new Transactions();

        // retrieve existing sales_order_lines data
        $oldSalesOrderReturnLineIds = SalesOrderReturnLines::find()->select('id')
            ->where(['sales_order_return_id' => $id])->asArray()->all();
        $oldSalesOrderReturnLineIds = ArrayHelper::getColumn($oldSalesOrderReturnLineIds,'id');
        $modelsSalesOrderReturnLines = SalesOrderReturnLines::findAll(['id' => $oldSalesOrderReturnLineIds]);
        $modelsSalesOrderReturnLines = (empty($modelsSalesOrderReturnLines)) ? [new SalesOrderReturnLines] : $modelsSalesOrderReturnLines;

        $modelSalesOrderReturn->count = SalesOrderReturnLines::find()->select('id')
            ->where(['sales_order_return_id' => $id])->count();

        // handle POST
        if ($modelSalesOrderReturn->load(Yii::$app->request->post())) {

            // get stock data from POST
            $modelsSalesOrderReturnLines = DynamicForms::createMultiple(SalesOrderReturnLines::classname(), $modelsSalesOrderReturnLines);
            DynamicForms::loadMultiple($modelsSalesOrderReturnLines, Yii::$app->request->post());
            $newSalesOrderReturnLineIds = ArrayHelper::getColumn($modelsSalesOrderReturnLines,'id');

            // delete removed data
            $delSalesOrderLineIds = array_diff($oldSalesOrderReturnLineIds,$newSalesOrderReturnLineIds);
            if (! empty($delSalesOrderLineIds)) SalesOrderReturnLines::deleteAll(['id' => $delSalesOrderLineIds]);

            // validate all models
            $valid = $modelSalesOrderReturn->validate();
            $valid = SalesOrderReturnLines::validateSalesOrderReturn($modelsSalesOrderReturnLines) && $valid;

            // save sales_order data
            if ($valid) {
                if ($this->saveSalesOrderReturn($generate,$modelSalesOrderReturn,$modelsSalesOrderReturnLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The sales order return number {id} has been saved.', ['id' => $modelSalesOrderReturn->id]));
                    return $this->redirect('/sales-order-return/index');
                }
            }
        }

        // show VIEW
        return $this->render('update', [
            'modelSalesOrderReturn' => $modelSalesOrderReturn,
            'modelCustomer' => $modelCustomer,
            'modelsSalesOrderReturnLines'  => $modelsSalesOrderReturnLines,

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
    protected function saveSalesOrderReturn($generate,$modelTransactions,$modelStock,$modelSalesOrderReturn,$modelsSalesOrderReturnLines) {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $modelSalesOrderReturn->user_id = Yii::$app->user->getId();
            $modelSalesOrderReturn->time = date('Y-m-d H:i:s');
            $modelSalesOrderReturn->balance = $modelSalesOrderReturn->total - $modelSalesOrderReturn->paid;

            if(empty($modelSalesOrderReturn->number))
                $modelSalesOrderReturn->number = 'SOR-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);

            if($modelSalesOrderReturn->paid > 0)
            {
                // Returned, Invoiced
                $modelSalesOrderReturn->status = 11;
            }
            else {
                // Returned, Uninvoiced
                $modelSalesOrderReturn->status = 12;
            }
            if ($go = $modelSalesOrderReturn->save(false)) {

                // Transactions

                // When the items are return
                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelSalesOrderReturn->customer->paymentMethod->name;
                $modelTransactions->remarks = "Items returned by ". $modelSalesOrderReturn->customer->name. " at ".$modelSalesOrderReturn->time." by ".$modelSalesOrderReturn->user->username;
                $modelTransactions->debit = abs($modelSalesOrderReturn->total);
                $modelTransactions->account = "sales return";
                $modelTransactions->credit = 0;

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                $modelTransactions = new Transactions;
                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelSalesOrderReturn->customer->paymentMethod->name;
                $modelTransactions->remarks = "Items returned by ". $modelSalesOrderReturn->customer->name. " at ".$modelSalesOrderReturn->time." by ".$modelSalesOrderReturn->user->username;
                $modelTransactions->credit = abs($modelSalesOrderReturn->total);
                $modelTransactions->account = "payable";
                $modelTransactions->debit = 0;

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                // when the cash has given to the customer 
                // in respect of the sales return 
                $modelTransactions = new Transactions;
                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelSalesOrderReturn->customer->paymentMethod->name;
                $modelTransactions->remarks = "Cash Issued to ". $modelSalesOrderReturn->customer->name. " at ".$modelSalesOrderReturn->time." by ".$modelSalesOrderReturn->user->username;
                $modelTransactions->debit = abs($modelSalesOrderReturn->total);
                $modelTransactions->account = "payable";
                $modelTransactions->credit = 0;

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                $modelTransactions = new Transactions;
                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelSalesOrderReturn->customer->paymentMethod->name;
                $modelTransactions->remarks = "Cash Issued to ". $modelSalesOrderReturn->customer->name. " at ".$modelSalesOrderReturn->time." by ".$modelSalesOrderReturn->user->username;
                $modelTransactions->credit = abs($modelSalesOrderReturn->total);
                $modelTransactions->account = "cash";
                $modelTransactions->debit = 0;
                
                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                // loop through each SalesOrderReturnLines
                foreach ($modelsSalesOrderReturnLines as $i => $modelSalesOrderReturnLine) {

                    // save the SalesOrderReturnLines record
                    if($modelSalesOrderReturnLine->quantity > 0) {
                        $modelSalesOrderReturnLine->active = true;
                        $modelSalesOrderReturnLine->user_id = Yii::$app->user->getId();
                        $modelSalesOrderReturnLine->time = date('Y-m-d H:i:s');
                        $modelSalesOrderReturnLine->sales_order_return_id = $modelSalesOrderReturn->id;
                        $modelSalesOrderReturnLine->item_name = $modelSalesOrderReturnLine->product->item_name;
                        $modelSalesOrderReturnLine->item_code = $modelSalesOrderReturnLine->product->item_code;
                        $modelSalesOrderReturnLine->sub_total = $modelSalesOrderReturnLine->quantity * $modelSalesOrderReturnLine->unit_price;
                        $modelSalesOrderReturnLine->sub_total = $modelSalesOrderReturnLine->sub_total - ($modelSalesOrderReturnLine->discount/100) * $modelSalesOrderReturnLine->sub_total;


                        // Stock

                        $modelStock->active = true;
                        $modelStock->user_id = Yii::$app->user->getId();
                        $modelStock->time = date('Y-m-d H:i:s');
                        $modelStock->product_id = $modelSalesOrderReturnLine->product_id;
                        $modelStock->quantity = $modelSalesOrderReturnLine->quantity;
                        $modelStock->location_id = $modelSalesOrderReturnLine->product->default_location_id;
                        $modelStock->product_category_id = $modelSalesOrderReturnLine->product->product_category_id;

                        if($modelSalesOrderReturnLine->product->last_vendor_id !== null){
                            $modelStock->last_vendor_id = $modelSalesOrderReturnLine->product->last_vendor_id;
                        }

                        if (! ($go = $modelSalesOrderReturnLine->save(false) && $modelStock->save(false))) {
                            $transaction->rollBack();
                            break;
                        }

                        $modelStock = new Stock;
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
     * Deletes an existing SalesOrderReturn model.
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
     * Finds the SalesOrderReturn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesOrderReturn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesOrderReturn::findOne($id)) !== null) {
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
    protected function findModelSalesOrderReturnLines($id)
    {
        if (($modelSalesOrderReturnLines = SalesOrderReturnLines::find($id)) !== null) {
            return $modelSalesOrderReturnLines;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
