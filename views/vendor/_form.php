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
            
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1"> Vendor Info</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2">Extra Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="row"></div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'name')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'balance')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'credit')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'discount')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'payment_terms')->textInput(['maxlength' => true]) ?>
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
                                        <?= $form->field($modelVendor, 'contact')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'phone')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'email')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                </div>
                                <div class="row">

                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'website')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'fax')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'address')->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?= $form->field($modelVendor, 'taxing_scheme_id')->dropDownList(ArrayHelper::map(TaxingScheme::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelVendor, 'remarks')->textarea(['rows' => 6])->hint('Optional') ?>
                                    </div> 
                                        
                                </div>
                            </div>
                        </div>

                        <div id="tab-2" class="tab-pane">
                                
                            <div class="panel-body">
                                <div class="row m-t-lg"></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <i class="fa fa-info-circle"></i> Preferences
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <?= $form->field($modelVendor, 'payment_method_id')->dropDownList(ArrayHelper::map(PaymentMethod::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($modelVendor->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
                

    <?php ActiveForm::end(); ?>
</div>