<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Customer;
use app\models\Location;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;

?>
<div class="sales-order-return-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'customer_id')->dropDownList(ArrayHelper::map(Customer::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>

    <?= $form->field($model, 'status')->dropDownList(['10'=>'Unreturned, Uninvoiced','11'=>'Returned, Invoiced','12'=>'Returned, Uninvoiced'],['prompt' => '','maxlength' => true, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'location_id')->dropDownList(ArrayHelper::map(Location::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>

    <?= $form->field($model, 'sales_rep_id')->dropDownList(ArrayHelper::map(User::find()->where(['status' => 10 ])->orderBy('username ASC')->all(), 'id', 'username'),['prompt' => '', 'class' => 'form-control']) ?>

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
