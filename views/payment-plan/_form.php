<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount_paid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_due')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_in_arrears')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goodwill_in_arrears')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rent_in_arrears')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
