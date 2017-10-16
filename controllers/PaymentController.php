<?php

namespace app\controllers;

use Yii;
use app\models\Payment;
use app\models\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Agreement;
use app\models\Property;
use app\models\Document;
use app\models\DocumentSearch;
use app\models\PaymentPlan;
use yii\web\UploadedFile;
use yii\db\Transaction;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
     * Lists all Payment Plan models.
     * @return json
     */
    public function actionGetGoodwillSummary($id) 
    {
        // id is the payment_id
        $modelAgreement = Agreement::findOne($id);
        $modelPaymentPlan = PaymentPlan::find()->select(['currency'])->where('payment_plan.agreement_id=:agreement_id', [':agreement_id' => $modelAgreement->id])->one();
        $total_goodwill_arrears = PaymentPlan::find()->select(['payment_plan.goodwill_in_arrears'])->where('payment_plan.agreement_id=:agreement_id and payment_plan.notes=:notes',[':agreement_id' => $modelAgreement->id, ':notes' => 'Goodwill'])->orderBy('id DESC')->one();
        $total_rent_arrears = PaymentPlan::find()->select(['payment_plan.rent_in_arrears'])->where('payment_plan.agreement_id=:agreement_id and payment_plan.notes=:notes',[':agreement_id' => $modelAgreement->id, ':notes' => 'Rent'])->orderBy('id DESC')->one();

        //$total_goodwill_arrears = PaymentPlan::find()->select(['payment_plan.goodwill_in_arrears'])->where(['payment_plan.agreement_id' => $modelAgreement->id, 'payment_plan.notes' => 'Rent'])->sum('payment_plan.amount_paid');
        //$total_rent_arrears = PaymentPlan::find()->select(['payment_plan.rent_in_arrears'])->where(['payment_plan.agreement_id' => $modelAgreement->id, 'payment_plan.notes' => 'Rent'])->sum('payment_plan.amount_in_arrears');

        $payment_plan_summary = array('currency' => $modelPaymentPlan->currency,'total_rent_paid' => $modelAgreement->total_rent_paid, 'total_goodwill_paid' => $modelAgreement->total_goodwill_paid);
        echo json_encode($payment_plan_summary);
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('payment_id = :field1', [':field1' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelDocument' => $this->findModelDocument($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payment();
        $modelDocument = new Document();
        $total_rent_paid = 0;
        $total_rent_arrears = 0;
        $total_goodwill_paid = 0;
        $total_goodwill_arrears = 0;


        if (Yii::$app->request->isPost) {

            $model->load(Yii::$app->request->post());
            $modelDocument->load(Yii::$app->request->post());

            //load Agreement
            $modelAgreement = Agreement::find()->where(['id' => $model->agreement_id])->one();

            if (!is_null($modelAgreement)) {
                if($model->type === "Rent"){
                    $modelAgreement->total_rent_paid = $modelAgreement->total_rent_paid + $model->amount_paid;
                }else{
                    $modelAgreement->total_goodwill_paid = $modelAgreement->total_goodwill_paid + $model->amount_paid;
                }
            }

            //Payment
            $model->currency = $modelAgreement->property->propertyType->currency->prefix;
            $model->user_id = Yii::$app->user->getId();
            $model->date = date('Y-m-d', strtotime($model->date));
            $model->time = date('Y-m-d H:i:s');

            //load PaymentPlan
            $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

            $month = (int)date('m', strtotime($model->date));
            $year = (int)date('Y', strtotime($model->date));

            

            if($modelAgreement->frequency === "Yearly"){
                $modelPaymentPlan = PaymentPlan::find()->where(['agreement_id' => $model->agreement_id, 'frequency' => $year, 'notes' => trim($model->type)])->one();
            }else{
                $modelPaymentPlan = PaymentPlan::find()->where(['agreement_id' => $model->agreement_id, 'frequency' => $months[$month], 'notes' => trim($model->type)])->one();
            }
            
            if (!is_null($modelPaymentPlan)) {
                if($model->type === "Rent"){
                    $modelPaymentPlan->rent_in_arrears = $modelPaymentPlan->running_total - $modelAgreement->total_rent_paid;
                }else{
                    $modelPaymentPlan->goodwill_in_arrears = $modelPaymentPlan->running_total - $modelAgreement->total_goodwill_paid;
                }
                
                $modelPaymentPlan->amount_paid = $modelPaymentPlan->amount_paid + $model->amount_paid;
            }


            //Document
            $modelDocument->user_id = Yii::$app->user->getId();
            $modelDocument->time = date('Y-m-d H:i:s');
            $modelDocument->notes = "Document attached during payment";

            $image = UploadedFile::getInstance($modelDocument, 'image');

            if (!is_null($image)) {
                $modelDocument->image_src_filename = $image->name;
                $tmp = explode(".", $image->name);
                $ext = end($tmp);


                // generate a unique file name to prevent duplicate filenames
                $modelDocument->image_web_filename = Yii::$app->security->generateRandomString().".{$ext}";
                // the path to save file, you can set an uploadPath
                // in Yii::$app->params (as used in example below)                       
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/payment/';
                $path = Yii::$app->params['uploadPath'] . $modelDocument->image_web_filename;
                $image->saveAs($path);
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {

                $valid = $model->validate();
                $valid = $modelDocument->validate([
                    'user_id',
                ]) && $valid;

                if (is_null($modelAgreement)) {
                    $valid = false;
                    Yii::$app->getSession()->setFlash('danger', 'Agreement was not selected, Please select it.');
                }

                if (is_null($modelPaymentPlan)) {
                    $valid = false;
                    Yii::$app->getSession()->setFlash('danger', 'Payment Plan cannot be selected, Please check the date and the type');
                }

                if ($valid) {

                    // the model was validated, no need to validate it once more
                    $model->save();   
                    $modelDocument->payment_id = $model->id;
                    $modelDocument->save();   
                    $modelAgreement->save();
                    $modelPaymentPlan->save();

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);

                }else {
                    Yii::$app->getSession()->setFlash('danger', 'Request failed, Inputs are not correct.');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }
        } 

        return $this->render('create', [
            'model' => $model,
            'modelDocument' => $modelDocument,
            'total_rent_paid' => $total_rent_paid,
            'total_rent_arrears' => $total_rent_arrears,
            'total_goodwill_paid' => $total_goodwill_paid,
            'total_goodwill_arrears' => $total_goodwill_arrears

        ]);
    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDocument = new Document();

        $old_amount_paid = $model->amount_paid;
        $old_type = $model->type;

        if (Yii::$app->request->isPost) {

            $model->load(Yii::$app->request->post());
            $modelDocument->load(Yii::$app->request->post());

            //load Agreement
            $modelAgreement = Agreement::find()->where(['id' => $model->agreement_id])->one();

            if (!is_null($modelAgreement)) {
                if($old_type != $model->type){
                    if($model->type === "Rent"){
                        $modelAgreement->total_goodwill_paid = $modelAgreement->total_goodwill_paid - $old_amount_paid;
                        $modelAgreement->total_rent_paid = $modelAgreement->total_rent_paid + $model->amount_paid;
                    }else{
                        $modelAgreement->total_rent_paid = $modelAgreement->total_rent_paid - $old_amount_paid;
                        $modelAgreement->total_goodwill_paid = $modelAgreement->total_goodwill_paid + $model->amount_paid;
                    }
                }else
                {
                    if($model->type === "Rent"){
                        $modelAgreement->total_rent_paid = $modelAgreement->total_rent_paid - $old_amount_paid;
                        $modelAgreement->total_rent_paid = $modelAgreement->total_rent_paid + $model->amount_paid;
                    }else{
                        $modelAgreement->total_goodwill_paid = $modelAgreement->total_goodwill_paid - $old_amount_paid;
                        $modelAgreement->total_goodwill_paid = $modelAgreement->total_goodwill_paid + $model->amount_paid;
                    }
                }
            }

            $model->currency = $modelAgreement->property->propertyType->currency->prefix;
            $model->user_id = Yii::$app->user->getId();
            $model->date = date('Y-m-d', strtotime($model->date));
            $model->time = date('Y-m-d H:i:s');

            //load PaymentPlan
            $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

            $month = (int)date('m', strtotime($model->date));
            $year = (int)date('Y', strtotime($model->date));

            

            if($modelAgreement->frequency === "Yearly"){
                $modelPaymentPlan = PaymentPlan::find()->where(['agreement_id' => $model->agreement_id, 'frequency' => $year, 'notes' => trim($model->type)])->one();
            }else{
                $modelPaymentPlan = PaymentPlan::find()->where(['agreement_id' => $model->agreement_id, 'frequency' => $months[$month], 'notes' => trim($model->type)])->one();
            }
            
            if (!is_null($modelPaymentPlan)) {
                if($model->type === "Rent"){
                    $modelPaymentPlan->rent_in_arrears = $modelPaymentPlan->running_total - $modelAgreement->total_rent_paid;
                }else{
                    $modelPaymentPlan->goodwill_in_arrears = $modelPaymentPlan->running_total - $modelAgreement->total_goodwill_paid;
                }
                $modelPaymentPlan->amount_paid = $modelPaymentPlan->amount_paid - $old_amount_paid;
                $modelPaymentPlan->amount_paid = $modelPaymentPlan->amount_paid + $model->amount_paid;
            }
            
            //Document
            $modelDocument->user_id = Yii::$app->user->getId();
            $modelDocument->time = date('Y-m-d H:i:s');
            $modelDocument->notes = "Document attached during payment";

            $image = UploadedFile::getInstance($modelDocument, 'image');

            if (!is_null($image)) {
                $modelDocument->image_src_filename = $image->name;
                $tmp = explode(".", $image->name);
                $ext = end($tmp);
                // generate a unique file name to prevent duplicate filenames
                $modelDocument->image_web_filename = Yii::$app->security->generateRandomString().".{$ext}";
                // the path to save file, you can set an uploadPath
                // in Yii::$app->params (as used in example below)                       
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/payment/';
                $path = Yii::$app->params['uploadPath'] . $modelDocument->image_web_filename;
                $image->saveAs($path);
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {

                $valid = $model->validate();
                $valid = $modelDocument->validate([
                    'user_id',
                ]) && $valid;

                if (is_null($modelAgreement)) {
                    $valid = false;
                    Yii::$app->getSession()->setFlash('danger', 'Agreement was not selected, Please select it.');
                }

                if (is_null($modelPaymentPlan)) {
                    $valid = false;
                    Yii::$app->getSession()->setFlash('danger', 'Payment Plan cannot be selected, Please check the date and the type');
                }

                if ($valid) {

                    // the model was validated, no need to validate it once more
                    $model->save();   
                    $modelDocument->payment_id = $model->id;
                    $modelDocument->save(); 
                    $modelAgreement->save();
                    $modelPaymentPlan->save();

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);

                }else {
                    Yii::$app->getSession()->setFlash('danger', 'Request failed, Property not selected.');
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }
        } 

        return $this->render('create', [
            'model' => $model,
            'modelDocument' => $modelDocument,
        ]);
    }

    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction(
            Transaction::SERIALIZABLE
        );

        $model = $this->findModel($id);

        //load Agreement
        $modelAgreement = Agreement::find()->where(['id' => $model->agreement_id])->one();

        if (!is_null($modelAgreement)) {
            if($model->type === "Rent"){
                $modelAgreement->total_rent_paid = $modelAgreement->total_rent_paid - $model->amount_paid;
            }else{
                $modelAgreement->total_goodwill_paid = $modelAgreement->total_goodwill_paid - $model->amount_paid;
            }
        }

        //load PaymentPlan
        $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

        $month = (int)date('m', strtotime($model->date));
        $year = (int)date('Y', strtotime($model->date));

        if($modelAgreement->frequency === "Yearly"){
            $modelPaymentPlan = PaymentPlan::find()->where(['agreement_id' => $model->agreement_id, 'frequency' => $year, 'notes' => trim($model->type)])->one();
        }else{
            $modelPaymentPlan = PaymentPlan::find()->where(['agreement_id' => $model->agreement_id, 'frequency' => $months[$month], 'notes' => trim($model->type)])->one();

        }
        
        if (!is_null($modelPaymentPlan)) {
            $modelPaymentPlan->amount_in_arrears = $modelPaymentPlan->amount_in_arrears + $model->amount_paid;
            $modelPaymentPlan->amount_paid = $modelPaymentPlan->amount_paid - $model->amount_paid;
        }

        try {

            $valid = $model->delete();
            $valid = $modelAgreement->save() && $valid;
            $valid = $modelPaymentPlan->save() && $valid;

            if ($valid) {

                $transaction->commit();
                return $this->redirect(['index']);

            }else {
                Yii::$app->getSession()->setFlash('danger', 'Request failed, Inputs are not correct.');
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new BadRequestHttpException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
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
    protected function findModelDocument($id)
    {
        if (($modelDocument = Document::find($id)) !== null) {
            return $modelDocument;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
