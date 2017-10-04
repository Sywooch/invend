<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\PropertyType;

/* @var $this yii\web\View */
/* @var $model app\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-form">

    <?php $form = ActiveForm::begin(['id' => 'property-form']); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Property Form
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>
                <div class="col-sm-3">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'property_type_id')->dropDownList(ArrayHelper::map(PropertyType::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '']) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, 'active')->dropDownList(['1'=>'Yes','0'=>'No'],['disabled' => 'disabled']) ?>
                </div>
                
            </div>

            <div class="row">
                
                <div class="col-sm-3">
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-6">
                   <?= $form->field($model, 'notes')->textarea(['rows' => 6])->hint('Optional') ?>
                </div>

            </div><!-- end:row -->

        </div>
    </div>

     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
