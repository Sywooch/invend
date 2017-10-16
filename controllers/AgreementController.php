<?php

namespace app\controllers;

use Yii;
use app\models\Agreement;
use app\models\AgreementSearch;
use app\models\PaymentPlan;
use app\models\PaymentPlanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\widgets\GeneratePassword;
use yii\db\Transaction;
use app\models\Property;
use app\models\PropertyType;


/**
 * AgreementController implements the CRUD actions for Agreement model.
 */
class AgreementController extends Controller
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
     * Lists all PropertyType models.
     * @return json
     */
    public function actionGetPropertyType($id) 
    {
        $modelProperty = Property::findOne($id);
        $modelPropertyType = PropertyType::find()->select(['property_type.name', 'property_type.frequency', 'currency.prefix as currency'])->innerJoinWith('currency', false)->where(['property_type.id' => $modelProperty->property_type_id, 'property_type.active' => 1])->asArray()->one();

        echo json_encode($modelPropertyType);
    }

    /**
     * Lists all Agreement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgreementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agreement model.
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
     * Creates a new Agreement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agreement();
        $modelPaymentPlan = new PaymentPlan();
        $modelProperty = new Property();
        $generate = new GeneratePassword();
        $schedules = 0;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $modelProperty = Property::findOne($model->property_id);
            $model->user_id = Yii::$app->user->getId();
            $model->currency = $model->property->propertyType->currency->prefix;
            $model->time = date('Y-m-d H:i:s');
            $model->rent_start_date = date('Y-m-d', strtotime($model->rent_start_date));
            
            // Goodwill assignments
            if($model->property->propertyType->name === "Shops") {
                $model->goodwill_start_date = date('Y-m-d', strtotime($model->goodwill_start_date));
                $model->goodwill_end_date = date('Y-m-d', strtotime("+".$model->goodwill_duration." days"));
            }

            $schedules = $model->goodwill_duration;
            if($model->frequency === "Monthly") {
                $schedules = $model->goodwill_duration * 12;
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {

                $valid = $model->validate();
                
                if ($valid) {

                    // the model was validated, no need to validate it once more
                    $model->save();   

                    $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

                    // Saving Goodwill
                    if($model->property->propertyType->name === "Shops") {
                        $month = (int)date('m', strtotime($model->goodwill_start_date));
                        $year = (int)date('Y', strtotime($model->goodwill_start_date));

                        if($model->frequency === "Monthly") {
                            $frequency = $months[$month];
                        }else {
                            $frequency = $year;
                        }

                        $modelPaymentPlan->currency = $model->currency;
                        $modelPaymentPlan->user_id = Yii::$app->user->getId();
                        $modelPaymentPlan->time = $model->time;
                        $modelPaymentPlan->amount_due = $model->goodwill;
                        $modelPaymentPlan->running_total += $model->goodwill;
                        $modelPaymentPlan->frequency = $frequency;
                        $modelPaymentPlan->notes = "Goodwill";
                        $modelPaymentPlan->agreement_id = $model->id;  
                        $modelPaymentPlan->save(false); 
                    }
                    

                    // save payments
                    $month = (int)date('m', strtotime($model->rent_start_date));
                    $year = (int)date('Y', strtotime($model->rent_start_date));
                    $total = 0;
                    
                    for($i=0; $i < $schedules-1; $i++){
                        $total = $total + $model->rent_amount;
                        $modelPaymentPlan = new PaymentPlan();
                        $modelPaymentPlan->currency = $model->currency;
                        $modelPaymentPlan->user_id = 1; //Yii::$app->user->getId();
                        $modelPaymentPlan->time = $model->time;
                        $modelPaymentPlan->amount_due = $model->rent_amount;
                        $modelPaymentPlan->running_total =  $total;
                        
                        //reset month
                        if($month === 13){
                            $month = 1;
                        }
                        if($model->frequency === "Monthly") {
                            $frequency = $months[$month];
                        }else {
                            $frequency = $year;
                        }

                        $modelPaymentPlan->frequency = $frequency;
                        $modelPaymentPlan->notes = "Rent";
                        $modelPaymentPlan->agreement_id = $model->id;                       
                        $modelPaymentPlan->save(false); 
                        $month ++;
                        $year ++;
                    }    

                    // deacivate property
                    $modelProperty->active = 0;
                    $modelProperty->save();               

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelPaymentPlan' => $modelPaymentPlan,
            'modelProperty' => $modelProperty,
        ]);
    }

    /**
     * Updates an existing Agreement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelPaymentPlan = new PaymentPlan();
        $modelProperty = new Property();
        $old_property_id = $model->property_id;
        

        if ($model->load(Yii::$app->request->post())) {

            $model->currency = $model->property->propertyType->currency->prefix;
            $model->rent_start_date = date('Y-m-d', strtotime($model->rent_start_date));
            
            // Goodwill assignments
            if($model->property->propertyType->name === "Shops") {
                $model->goodwill_start_date = date('Y-m-d', strtotime($model->goodwill_start_date));
                $model->goodwill_end_date = date('Y-m-d', strtotime("+".$model->goodwill_duration." days"));
            }

            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } 

        return $this->render('update', [
            'model' => $model,
            'modelPaymentPlan' => $modelPaymentPlan,
            'modelProperty' => $modelProperty,
        ]);
        
    }

    /**
     * Deletes an existing Agreement model.
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
     * Finds the Agreement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agreement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agreement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
