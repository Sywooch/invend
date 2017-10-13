<?php

namespace app\controllers;

use Yii;
use app\models\SalesOrder;
use app\models\Customer;
use app\models\Stock;
use app\models\Transactions;
use app\models\SalesOrderLines;
use app\models\SalesOrderSearch;
use app\models\SalesOrderLinesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DynamicForms;
use yii\helpers\ArrayHelper;
use app\widgets\GeneratePassword;

/**
 * SalesOrderController implements the CRUD actions for SalesOrder model.
 */
class SalesOrderController extends Controller
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
     * Lists all SalesOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SalesOrderLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('sales_order_id = :field1', [':field1' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelSalesOrderLines' => $this->findModelSalesOrderLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = 'empty';
        $searchModel = new SalesOrderLinesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('sales_order_id = :field1', [':field1' => $id]);

        return $this->render('print', [
            'model' => $this->findModel($id),
            'modelSalesOrderLines' => $this->findModelSalesOrderLines($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SalesOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelSalesOrder = new SalesOrder();
        $modelCustomer = new Customer();
        $modelStock = new Stock();
        $generate = new GeneratePassword();
        $modelTransactions = new Transactions();
        $modelsSalesOrderLines = [new SalesOrderLines()];

        if ($modelSalesOrder->load(Yii::$app->request->post())) {

            // get SalesOrderLines data from POST
            $modelsSalesOrderLines = DynamicForms::createMultiple(SalesOrderLines::classname());
            DynamicForms::loadMultiple($modelsSalesOrderLines, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsSalesOrderLines),
                    ActiveForm::validate($modelSalesOrder)
                );
            }

            // validate all models - see example online for ajax validation
            $valid = $modelSalesOrder->validate();
            $valid = SalesOrderLines::validateSalesOrder($modelsSalesOrderLines) && $valid;

            // save sales_order data
            if ($valid) {
                $modelSalesOrder->reason = 1;
                $modelSalesOrder->number = 'SO-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);
                if ($this->saveSalesOrder($generate,$modelTransactions,$modelStock,$modelSalesOrder,$modelsSalesOrderLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The sales order number {id} has been saved.', ['id' => $modelSalesOrder->id]));
                    return $this->redirect('index');
                }
            }
        }

        return $this->render('create', [
            'modelSalesOrder' => $modelSalesOrder,
            'modelCustomer' => $modelCustomer,
            'modelsSalesOrderLines'  => (empty($modelsSalesOrderLines)) ? [new SalesOrderLines] : $modelsSalesOrderLines,
        ]);
    }

    /**
     * Updates an existing SalesOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // retrieve existing sales order data
        $modelSalesOrder = $this->findModel($id);
        $modelCustomer = new Customer();
        $generate = new GeneratePassword();
        $modelStock = new Stock();
        $modelTransactions = new Transactions();

        // retrieve existing sales_order_lines data
        $oldSalesOrderLineIds = SalesOrderLines::find()->select('id')
            ->where(['sales_order_id' => $id])->asArray()->all();
        $oldSalesOrderLineIds = ArrayHelper::getColumn($oldSalesOrderLineIds,'id');
        $modelsSalesOrderLines = SalesOrderLines::findAll(['id' => $oldSalesOrderLineIds]);
        $modelsSalesOrderLines = (empty($modelsSalesOrderLines)) ? [new SalesOrderLines] : $modelsSalesOrderLines;

        $modelSalesOrder->count = SalesOrderLines::find()->select('id')
            ->where(['sales_order_id' => $id])->count();

        // handle POST
        if ($modelSalesOrder->load(Yii::$app->request->post())) {

            // get stock data from POST
            $modelsSalesOrderLines = DynamicForms::createMultiple(SalesOrderLines::classname(), $modelsSalesOrderLines);
            DynamicForms::loadMultiple($modelsSalesOrderLines, Yii::$app->request->post());
            $newSalesOrderLineIds = ArrayHelper::getColumn($modelsSalesOrderLines,'id');

            // delete removed data
            $delSalesOrderLineIds = array_diff($oldSalesOrderLineIds,$newSalesOrderLineIds);
            if (! empty($delSalesOrderLineIds)) SalesOrderLines::deleteAll(['id' => $delSalesOrderLineIds]);

            // validate all models
            $valid = $modelSalesOrder->validate();
            $valid = SalesOrderLines::validateSalesOrder($modelsSalesOrderLines) && $valid;

            // save sales_order data
            if ($valid) {
                if ($this->saveSalesOrder($generate,$modelTransactions,$modelStock,$modelSalesOrder,$modelsSalesOrderLines)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The sales order number {id} has been saved.', ['id' => $modelSalesOrder->id]));
                    return $this->redirect('/sales-order/index');
                }
            }
        }

        // show VIEW
        return $this->render('update', [
            'modelSalesOrder' => $modelSalesOrder,
            'modelCustomer' => $modelCustomer,
            'modelsSalesOrderLines'  => $modelsSalesOrderLines,

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
    protected function saveSalesOrder($generate,$modelTransactions,$modelStock,$modelSalesOrder,$modelsSalesOrderLines) {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $modelSalesOrder->user_id = Yii::$app->user->getId();
            $modelSalesOrder->time = date('Y-m-d H:i:s');
            $modelSalesOrder->balance = $modelSalesOrder->total - $modelSalesOrder->paid;

            if(empty($modelSalesOrder->number))
                $modelSalesOrder->number = 'SO-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);

            if($modelSalesOrder->paid > 0)
            {
                // Fulfilled, Invoiced
                $modelSalesOrder->status = 8;
            }
            else {
                // Fulfilled, Uninvoiced
                $modelSalesOrder->status = 9;
            }
            if ($go = $modelSalesOrder->save(false)) {

                // Transactions

                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelSalesOrder->customer->paymentMethod->name;
                $modelTransactions->remarks = "We sold items to ". $modelSalesOrder->customer->name. " at ".$modelSalesOrder->time." by ".$modelSalesOrder->user->username;
                $modelTransactions->debit = $modelSalesOrder->total;
                $modelTransactions->account = "cash";
                $modelTransactions->credit = 0;

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                $modelTransactions = new Transactions;
                $modelTransactions->user_id = Yii::$app->user->getId();
                $modelTransactions->time = date('Y-m-d H:i:s');
                $modelTransactions->type = $modelSalesOrder->customer->paymentMethod->name;
                $modelTransactions->remarks = "We sold items to ". $modelSalesOrder->customer->name. " at ".$modelSalesOrder->time." by ".$modelSalesOrder->user->username;
                $modelTransactions->credit = $modelSalesOrder->total;
                $modelTransactions->account = "sales";
                $modelTransactions->debit = 0;
                

                if (! ($go = $modelTransactions->save(false))) {
                    $transaction->rollBack();
                }

                // loop through each SalesOrderLines
                foreach ($modelsSalesOrderLines as $i => $modelSalesOrderLine) {

                    // save the SalesOrderLines record
                    if($modelSalesOrderLine->quantity > 0) {
                        $modelSalesOrderLine->active = true;
                        $modelSalesOrderLine->user_id = Yii::$app->user->getId();
                        $modelSalesOrderLine->time = date('Y-m-d H:i:s');
                        $modelSalesOrderLine->sales_order_id = $modelSalesOrder->id;
                        $modelSalesOrderLine->item_name = $modelSalesOrderLine->product->item_name;
                        $modelSalesOrderLine->item_code = $modelSalesOrderLine->product->item_code;
                        $modelSalesOrderLine->sub_total = $modelSalesOrderLine->quantity * $modelSalesOrderLine->unit_price;
                        $modelSalesOrderLine->sub_total = $modelSalesOrderLine->sub_total - ($modelSalesOrderLine->discount/100) * $modelSalesOrderLine->sub_total;

                        // Stock

                        $modelStock->active = true;
                        $modelStock->user_id = Yii::$app->user->getId();
                        $modelStock->time = date('Y-m-d H:i:s');
                        $modelStock->product_id = $modelSalesOrderLine->product_id;
                        $modelStock->quantity = -1 * abs($modelSalesOrderLine->quantity);
                        $modelStock->location_id = $modelSalesOrderLine->product->default_location_id;
                        $modelStock->product_category_id = $modelSalesOrderLine->product->product_category_id;

                        if($modelSalesOrderLine->product->last_vendor_id !== null){
                            $modelStock->last_vendor_id = $modelSalesOrderLine->product->last_vendor_id;
                        }

                        if (! ($go = $modelSalesOrderLine->save(false) && $modelStock->save(false))) {
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
     * Deletes an existing SalesOrder model.
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
     * Finds the SalesOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesOrder::findOne($id)) !== null) {
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
    protected function findModelSalesOrderLines($id)
    {
        if (($modelSalesOrderLines = SalesOrderLines::find($id)) !== null) {
            return $modelSalesOrderLines;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
