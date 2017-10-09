<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use yii\helpers\ArrayHelper;
use app\models\Location;
use app\models\User;
use app\models\PaymentMethod;
use app\models\TaxingScheme;
use kartik\widgets\SwitchInput;

?>

<div class="vendor-form">
    <?php $form = ActiveForm::begin(['id' => 'vendor-form']); ?>
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
                    <li><a href="/po/create">Purchase Order</a></li>
                    <li><a href="/vendor/index">Vendor List</a></li>
                </ul>
            </div>
        </div>

        <div class="ibox-content">

            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($modelVendor, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelVendor, 'contact')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelVendor, 'active')->widget(SwitchInput::classname(),[
                        'options' => [
                            'value'=> true,
                        ],
                        'name' => 'active',
                        'value'=> 'true',
                        'type' => SwitchInput::CHECKBOX,

                        'pluginOptions' => [
                        
                            'size' => 'large',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => 'Yes',
                            'offText' => 'No',
                        ]
                    ]);?>

                </div>
            </div>
            <div class="row">

                
                <div class="col-sm-3">
                    <?= $form->field($modelVendor, 'phone')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelVendor, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelVendor, 'address')->textInput(['maxlength' => true]) ?>
                </div>
                
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($modelVendor->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
                

    <?php ActiveForm::end(); ?>
</div>