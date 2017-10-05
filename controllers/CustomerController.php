<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\widgets\GeneratePassword;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return json
     */
    public function actionGetCustomerInfo($id) 
    {
        $modelCustomer = Customer::find()->where(['customer.id' => $id, 'customer.active' => 1])->asArray()->one();
        echo json_encode($modelCustomer);
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelCustomer = new Customer();
        $generate = new GeneratePassword();
        
        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->user_id = Yii::$app->user->getId();
            $modelCustomer->time = date('Y-m-d H:i:s');
            if(empty($modelCustomer->number))
                $modelCustomer->number = 'CU-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);
            $modelCustomer->save();
            return $this->redirect(['view', 'id' => $modelCustomer->id]);
        } else {
            return $this->render('create', [
                'modelCustomer' => $modelCustomer,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelCustomer = $this->findModel($id);
        $generate = new GeneratePassword();

        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->user_id = Yii::$app->user->getId();
            $modelCustomer->time = date('Y-m-d H:i:s');
            if(empty($modelCustomer->number))
                $modelCustomer->number = 'CU-'.$generate->Generate(8,1,0,1).'-'.$generate->Generate(2,1,0,0);
            $modelCustomer->save();
            return $this->redirect(['view', 'id' => $modelCustomer->id]);
        } else {
            return $this->render('update', [
                'modelCustomer' => $modelCustomer,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
