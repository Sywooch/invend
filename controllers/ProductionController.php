<?php

namespace app\controllers;

use Yii;
use app\models\Production;
use app\models\ProductionSearch;
use app\models\Stock;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductionController implements the CRUD actions for Production model.
 */
class ProductionController extends Controller
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
     * Lists all Production models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Production model.
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
     * Creates a new Production model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Production();
        $modelStock = new Stock();
        $oldqtyproduced = 0;
        $oldqtywasted = 0;
        $oldendweight = 0;

        if ($model->load(Yii::$app->request->post())) {

            $this->saveProduction($oldqtyproduced,$oldqtywasted,$oldendweight,$model, $modelStock);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Production model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelStock = new Stock();
        $oldqtyproduced = $model->quantity_produced;
        $oldqtywasted = $model->quantity_wasted;
        $oldendweight = $model->end_weight;


        if ($model->load(Yii::$app->request->post())) {

            $this->saveProduction($oldqtyproduced,$oldqtywasted,$oldendweight,$model, $modelStock);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * This function saves each part of the product dynamic form controls.
     *
     * @param $modelProduct mixed The product model.
     * @param $modelsStock mixed The stock model from the product.
     * @return bool Returns TRUE if successful.
     * @throws NotFoundHttpException When record cannot be saved.
     */
    protected function saveProduction($oldqtyproduced,$oldqtywasted,$oldendweight,$model,$modelStock) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $model->active = true;
            $model->user_id = Yii::$app->user->getId();
            $model->time = date('Y-m-d H:i:s');
            $model->completed_date = $model->actual_prod_date;

            

            if ($go = $model->save(false)) {

                // Stock
                
                if($oldendweight != $model->end_weight)
                {
                    // Rolls
                    $modelStock->active = true;
                    $modelStock->user_id = Yii::$app->user->getId();
                    $modelStock->time = date('Y-m-d H:i:s');
                    $modelStock->product_id = 1;
                    $modelStock->product_category_id = 1;
                    $modelStock->quantity = abs($model->end_weight - $oldendweight);

                    if (! ($go = $modelStock->save(false))) {
                        $transaction->rollBack();
                    }
                }

                if($oldqtywasted != $model->quantity_wasted)
                {
                    // Bags
                    $modelStock = new Stock;
                    $modelStock->active = true;
                    $modelStock->user_id = Yii::$app->user->getId();
                    $modelStock->time = date('Y-m-d H:i:s');
                    $modelStock->product_id = 2;
                    $modelStock->product_category_id = 1;
                    $modelStock->quantity = -1 * abs($model->quantity_wasted - $oldqtywasted);
                    $modelStock->remarks = 'wastage';

                    if (! ($go = $modelStock->save(false))) {
                        $transaction->rollBack();
                    }
                }
                

                if($oldqtyproduced != $model->quantity_produced)
                {
                    // Bags
                    $modelStock = new Stock;
                    $modelStock->active = true;
                    $modelStock->user_id = Yii::$app->user->getId();
                    $modelStock->time = date('Y-m-d H:i:s');
                    $modelStock->product_id = 2;
                    $modelStock->product_category_id = 1;
                    $modelStock->quantity = -1 * abs($model->quantity_produced - $oldqtyproduced);

                    if (! ($go = $modelStock->save(false))) {
                        $transaction->rollBack();
                    }

                    // Sachet Water
                    $modelStock = new Stock;
                    $modelStock->active = true;
                    $modelStock->user_id = Yii::$app->user->getId();
                    $modelStock->time = date('Y-m-d H:i:s');
                    $modelStock->product_id = 3;
                    $modelStock->product_category_id = 2;
                    $modelStock->quantity = abs($model->quantity_produced - $oldqtyproduced);

                    if (! ($go = $modelStock->save(false))) {
                        $transaction->rollBack();
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
     * Deletes an existing Production model.
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
     * Finds the Production model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Production the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Production::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
