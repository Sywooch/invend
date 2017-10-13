<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transactions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'account') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(),[
          'options' => [
            'placeholder' => '',
            'value' => date('d-m-Y'),
          ],
          
          'type' => DatePicker::TYPE_COMPONENT_APPEND,
          'readonly' => true,

          'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => TRUE,
                
            ]
    ]);?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
