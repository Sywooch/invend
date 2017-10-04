<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'amount_paid') ?>

    <?= $form->field($model, 'amount_changed') ?>

    <?= $form->field($model, 'receipt_number') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'mode') ?>

    <?= $form->field($model, 'cheque_number') ?>

    <?= $form->field($model, 'payee_name') ?>

    <?= $form->field($model, 'payee_mobile_number') ?>

    <?= $form->field($model, 'payee_email') ?>

    <?= $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
