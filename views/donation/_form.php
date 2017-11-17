<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use app\models\Location;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

?>

<div class="donation-form">
    <?php $form = ActiveForm::begin(['id' => 'donation-form']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">

            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="/expenses/create">New Expenses</a></li>
                    <li><a href="/donation/index">Donation List</a></li>
                </ul>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
                </div>

                
                <div class="col-sm-6">
                    <?= $form->field($model, 'reason')->textarea(['rows' => 3])->hint('Mandatory') ?>
                </div> 
            </div>
            <div class="row">
                <div class="col-sm-3">
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

                </div>

                <div class="col-sm-6">
                    <?= $form->field($model, 'notes')->textarea(['rows' => 6])->hint('Optional') ?>
                </div> 
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
                

    <?php ActiveForm::end(); ?>
</div>