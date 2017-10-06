<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Bom;
use app\models\BomStages;
use app\models\BomComponents;
use app\models\BomInstructions;
use app\models\BomOutputs;
use app\models\DynamicForms;
use app\models\BomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BomController implements the CRUD actions for Bom model.
 */
class BomController extends Controller
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
     * Lists all Bom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bom model.
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
     * Creates a new Bom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate() {

        $modelBom = new Bom();
        $modelsStage = [new BomStages()];
        $modelsComponents[] = [new BomComponents];
        $modelsOutput = [new BomOutputs()];

        if ($modelBom->load(Yii::$app->request->post())) {

            // get Outputs data from POST
            $modelsOutput = DynamicForms::createMultiple(BomOutputs::classname());
            DynamicForms::loadMultiple($modelsOutput, Yii::$app->request->post());

            // get Stages data from POST
            $modelsStage = DynamicForms::createMultiple(BomStages::classname());
            DynamicForms::loadMultiple($modelsStage, Yii::$app->request->post());

            // get Components data from POST
            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
            for ($i=0; $i<count($modelsStage); $i++) {
                $loadsData['BomComponents'] =  Yii::$app->request->post()['BomComponents'][$i];
                $modelsComponents[$i] = DynamicForms::createMultiple(BomComponents::classname(),[] ,$loadsData);
                DynamicForms::loadMultiple($modelsComponents[$i], $loadsData);
            }

            // validate all models - see example online for ajax validation

            $valid = $modelBom->validate();
            $valid = BomStages::validateBom($modelsStage,$modelsComponents) && $valid;
            $valid = BomOutputs::validateBom($modelsOutput) && $valid;

            // save bom data
            if ($valid) {
                if ($this->saveBom($modelBom,$modelsOutput,$modelsStage,$modelsComponents)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The bom number {id} has been saved.', ['id' => $modelBom->id]));
                    return $this->redirect('index');
                }
            }
        }

        return $this->render('create', [
            'modelBom' => $modelBom,
            'modelsStage'  => (empty($modelsStage)) ? [new BomStages] : $modelsStage,
            'modelsOutput'  => (empty($modelsOutput)) ? [new BomOutputs] : $modelsOutput,
            'modelsComponents' => (empty($modelsComponents)) ? [new BomComponents] : $modelsComponents,
        ]);
    }



    public function actionUpdate($id) {

        // retrieve existing bom data
        $modelBom = $this->findModel($id);

        // retrieve existing Output data
        $oldOutputIds = BomOutputs::find()->select('id')
            ->where(['bom_id' => $id])->asArray()->all();
        $oldOutputIds = ArrayHelper::getColumn($oldOutputIds,'id');
        $modelsOutput = BomOutputs::findAll(['id' => $oldOutputIds]);
        $modelsOutput = (empty($modelsOutput)) ? [new BomOutputs] : $modelsOutput;

        // retrieve existing Stage data
        $oldStageIds = BomStages::find()->select('id')
            ->where(['bom_id' => $id])->asArray()->all();
        $oldStageIds = ArrayHelper::getColumn($oldStageIds,'id');
        $modelsStage = BomStages::findAll(['id' => $oldStageIds]);
        $modelsStage = (empty($modelsStage)) ? [new BomStages] : $modelsStage;

        // retrieve existing Components data
        $oldComponentIds = [];
        foreach ($modelsStage as $i => $modelStage) {
            $oldComponents = BomComponents::findAll(['bom_stages_id' => $modelStage->id]);
            $modelsComponents[$i] = $oldComponents;
            $oldComponentIds = array_merge($oldComponentIds,ArrayHelper::getColumn($oldComponents,'id'));
            $modelsComponents[$i] = (empty($modelsComponents[$i])) ? [new BomComponents] : $modelsComponents[$i];
        }

        // handle POST
        if ($modelBom->load(Yii::$app->request->post())) {

            // get Output data from POST
            $modelsOutput = DynamicForms::createMultiple(BomOutputs::classname(), $modelsOutput);
            DynamicForms::loadMultiple($modelsOutput, Yii::$app->request->post());
            $newOutputIds = ArrayHelper::getColumn($modelsOutput,'id');

            // get Stage data from POST
            $modelsStage = DynamicForms::createMultiple(BomStages::classname(), $modelsStage);
            DynamicForms::loadMultiple($modelsStage, Yii::$app->request->post());
            $newStageIds = ArrayHelper::getColumn($modelsStage,'id');

            // get BomComponents data from POST
            $newComponentIds = [];
            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
            for ($i=0; $i<count($modelsStage); $i++) {
                if( !isset($modelsComponents[$i]) ){
                   $modelsComponents[$i] = DynamicForms::createMultiple(BomComponents::classname(), [], $loadsData);
                }
                $loadsData['BomComponents'] =  Yii::$app->request->post()['BomComponents'][$i];
                $modelsComponents[$i] = DynamicForms::createMultiple(BomComponents::classname(), $modelsComponents[$i], $loadsData);
                DynamicForms::loadMultiple($modelsComponents[$i], $loadsData);
                $newComponentIds = array_merge($newComponentIds,ArrayHelper::getColumn($loadsData['BomComponents'],'id'));
            }
            
            // delete removed data
            $delComponentIds = array_diff($oldComponentIds,$newComponentIds);
            if (! empty($delComponentIds)) BomComponents::deleteAll(['id' => $delComponentIds]);

            $delStageIds = array_diff($oldStageIds,$newStageIds);
            if (! empty($delStageIds)) BomStages::deleteAll(['id' => $delStageIds]);

            $delOutputIds = array_diff($oldOutputIds,$newOutputIds);
            if (! empty($delOutputIds)) BomOutputs::deleteAll(['id' => $delOutputIds]);

            // validate all models
            $valid = $modelBom->validate();
            $valid = BomStages::validateBom($modelsStage,$modelsComponents) && $valid;
            $valid = BomOutputs::validateBom($modelsOutput) && $valid;

            //$valid = true;

            // save bom data
            if ($valid) {
                if ($this->saveBom($modelBom,$modelsOutput,$modelsStage,$modelsComponents)) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t('app','The bom number {id} has been saved.', ['id' => $modelBom->id]));
                    return $this->redirect('/bom/index');
                }
            }
        }

        // show VIEW
        return $this->render('update', [
            'modelBom' => $modelBom,
            'modelsStage'  => $modelsStage,
            'modelsOutput'  => $modelsOutput,
            'modelsComponents' => $modelsComponents,
            'total_component' => $total_component,
        ]);
    }


    /**
     * This function saves each part of the deposit dynamic form controls.
     *
     * @param $modelDeposit mixed The Deposit model.
     * @param $modelsStage mixed The BomStages model from the deposit.
     * @param $modelsComponents mixed The BomComponents model from the deposit.
     * @return bool Returns TRUE if successful.
     * @throws NotFoundHttpException When record cannot be saved.
     */
    protected function saveBom($modelBom,$modelsOutput,$modelsStage,$modelsComponents) {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $modelBom->user_id = Yii::$app->user->getId();
            $modelBom->time = date('Y-m-d H:i:s');
            if ($go = $modelBom->save()) {

                // loop through each outputs
                foreach ($modelsOutput as $j => $modelOutput) {
                    // save the output record
                    $modelOutput->active = true;
                    $modelOutput->user_id = Yii::$app->user->getId();
                    $modelOutput->time = date('Y-m-d H:i:s');
                    $modelOutput->bom_id = $modelBom->id;

                    if (! ($go = $modelOutput->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }

                // loop through each stages
                foreach ($modelsStage as $i => $modelStage) {
                    // save the stage record
                    $modelStage->active = true;
                    $modelStage->user_id = Yii::$app->user->getId();
                    $modelStage->time = date('Y-m-d H:i:s');
                    $modelStage->bom_id = $modelBom->id;
                    $modelStage->number = $modelStage->name . '-'. $i;
                    $modelStage->description = $modelStage->number .' for ' .$modelBom->name;

                    if ($go = $modelStage->save(false)) {
                        // loop through each component
                        foreach ($modelsComponents[$i] as $ix => $modelComponent) {

                            //if($ix !== 'total_component') {
                                $modelComponent->active = true;
                                $modelComponent->user_id = Yii::$app->user->getId();
                                $modelComponent->time = date('Y-m-d H:i:s');
                                $modelComponent->bom_stages_id = $modelStage->id;

                                if (! ($go = $modelComponent->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            //}
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
     * Deletes an existing Bom model.
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
     * Finds the Bom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
