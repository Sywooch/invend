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

<div class="distribution-return-form">
    <?php $form = ActiveForm::begin(['id' => 'distribution-return-form']); ?>
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
                    <li><a href="/distribution/create">New Distribution</a></li>
                    <li><a href="/distribution/index">Distribution List</a></li>
                </ul>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'driver_id')->dropDownList(ArrayHelper::map(User::find()->where(['status' => 10, 'type' => 2 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control', 'onChange' => 'getDriver(this)']) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
                </div>

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
            </div>
            <div class="row">
                <div class="col-sm-9">
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