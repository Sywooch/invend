<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Stock;
use app\models\DynamicForms;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\widgets\GeneratePassword;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return json
     */
    public function actionGetProductInfo($id) 
    {
        $modelProduct = Product::find()->where(['product.id' => $id, 'product.active' => 1])->asArray()->one();
        echo json_encode($modelProduct);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate() {

        $modelProduct = new Product();
        $generate = new GeneratePassword();
        $modelsStock = [new Stock()];

        if ($modelProduct->load(Yii::$app->request->post())) {

            // get Stock data from POST
            $modelsStock = DynamicForms::createMultiple(Stock::classname());
            DynamicForms::loadMultiple($modelsStock, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsStock),
                    ActiveForm::validate($modelProduct)
                );
            }

            // validate all models - see example online for ajax validation
            $valid = $modelProduct->validate();
            $valid = Stock::validateProduct($modelsStock) && $valid;

            // save product data
            if ($valid) {
                if ($this->saveProduct($generate,$modelProduct,$modelsStock)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The product number {id} has been saved.', ['id' => $modelProduct->id]));
                    return $this->redirect('index');
                }
            }
        }

        return $this->render('create', [
            'modelProduct' => $modelProduct,
            'modelsStock'  => (empty($modelsStock)) ? [new Stock] : $modelsStock,
        ]);
    }


    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id) {

        // retrieve existing product data
        $modelProduct = $this->findModel($id);
        $generate = new GeneratePassword();

        // retrieve existing stock data
        $oldStockIds = Stock::find()->select('id')
            ->where(['product_id' => $id])->asArray()->all();
        $oldStockIds = ArrayHelper::getColumn($oldStockIds,'id');
        $modelsStock = Stock::findAll(['id' => $oldStockIds]);
        $modelsStock = (empty($modelsStock)) ? [new Stock] : $modelsStock;

        // handle POST
        if ($modelProduct->load(Yii::$app->request->post())) {

            // get stock data from POST
            $modelsStock = DynamicForms::createMultiple(Stock::classname(), $modelsStock);
            DynamicForms::loadMultiple($modelsStock, Yii::$app->request->post());
            $newStockIds = ArrayHelper::getColumn($modelsStock,'id');

            // delete removed data
            $delStockIds = array_diff($oldStockIds,$newStockIds);
            if (! empty($delStockIds)) Stock::deleteAll(['id' => $delStockIds]);

            // validate all models
            $valid = $modelProduct->validate();
            $valid = Stock::validateProduct($modelsStock) && $valid;

            // $valid = true;
            // save product data
            if ($valid) {
                if ($this->saveProduct($generate,$modelProduct,$modelsStock)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The product number {id} has been saved.', ['id' => $modelProduct->id]));
                    return $this->redirect('/product/index');
                }
            }
        }

        // show VIEW
        return $this->render('Update', [
            'modelProduct' => $modelProduct,
            'modelsStock'  => $modelsStock,
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
    protected function saveProduct($generate,$modelProduct,$modelsStock) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $modelProduct->user_id = Yii::$app->user->getId();
            $modelProduct->time = date('Y-m-d H:i:s');
            if(empty($modelProduct->number))
                $modelProduct->item_code = 'P-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);


            if ($go = $modelProduct->save()) {

                // loop through each stocks
                foreach ($modelsStock as $i => $modelStock) {
                    // save the stage record
                    if($modelStock->quantity > 0) {
                        $modelStock->active = true;
                        $modelStock->user_id = Yii::$app->user->getId();
                        $modelStock->time = date('Y-m-d H:i:s');
                        $modelStock->product_id = $modelProduct->id;
                        $modelStock->product_category_id = $modelProduct->product_category_id;
                        $modelStock->last_vendor_id = $modelProduct->last_vendor_id;

                        if (! ($go = $modelStock->save())) {
                            $transaction->rollBack();
                            break;
                        }
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
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
