<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\DistributionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribution-return-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'driver_id')->dropDownList(ArrayHelper::map(User::find()->where(['status' => 10, 'type' => 2 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control', 'onChange' => 'getDriver(this)']) ?>

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
