<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use app\models\ProductType;
use app\models\Location;
use app\models\Vendor;
use app\models\Uom;
use app\models\ProductCategory;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

?>

<div class="production-form">
    <?php $form = ActiveForm::begin(['id' => 'production-form']); ?>
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
                    <li><a href="/po/return">Purchase Return</a></li>
                    <li><a href="/po/index">Purchase List</a></li>
                </ul>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'actual_prod_date')->widget(DatePicker::classname(),[
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
                <div class="col-sm-4">
                    <?= $form->field($model, 'start_weight')->textInput(['maxlength' => true, 'onchange' => 'getNetWeight(this);']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'quantity_produced')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
                

    <?php ActiveForm::end(); ?>
</div>