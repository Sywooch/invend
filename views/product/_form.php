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
use kartik\widgets\SwitchInput;

?>

<div class="product-form">
    <?php $form = ActiveForm::begin(['id' => 'product-form']); ?>
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
                    <li><a href="/po/return">Return</a></li>
                    <li><a href="/po/index">Order List</a></li>
                </ul>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($modelProduct, 'item_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelProduct, 'product_category_id')->dropDownList(ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name'),['prompt' => '']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelProduct, 'active')->widget(SwitchInput::classname(),[
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
                    <?= $form->field($modelProduct, 'standard_uom_id')->dropDownList(ArrayHelper::map(Uom::find()->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelProduct, 'wholesale_price')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelProduct, 'cost')->textInput(['maxlength' => 10]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label>Quantity on Hand </label>
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'stock_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-stocks', // required: css class selector
                        'widgetItem' => '.stock-item', // required: css class
                        'insertButton' => '.add-stock', // css class
                        'deleteButton' => '.del-stock', // css class
                        'model' => $modelsStock[0],
                        'formId' => 'product-form',
                        'formFields' => [
                            'location_id',
                            'quantity',
                        ],
                    ]); ?>
                    
                    <div class="table-responsive">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="active">
                                <td></td>
                                <td class="col-xs-9"><?= Html::activeLabel($modelsStock[0], 'location_id'); ?></td>
                                <td class="col-xs-3"><?= Html::activeLabel($modelsStock[0], 'quantity'); ?></td>
                            </tr>
                        </thead>

                        <tbody class="container-stocks"><!-- widgetContainer -->
                        <?php foreach ($modelsStock as $i => $modelStock): ?>

                            <tr class="stock-item"><!-- widgetBody -->
                                <td>
                                    <button type="button" class="del-stock btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    <?php
                                    // necessary for update action.
                                    if (! $modelStock->isNewRecord) {
                                        echo Html::activeHiddenInput($modelStock, "[{$i}]id");
                                    }else {
                                        $modelsStock[0]->quantity = 0;
                                        $modelsStock[0]->location_id = 1;
                                    }
                                    
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $form->field($modelStock, "[{$i}]location_id")->begin();
                                        echo Html::activeDropDownList($modelStock, "[{$i}]location_id", ArrayHelper::map(Location::find()->all(), 'id', 'name'), ['prompt' => '','maxlength' => true, 'class' => 'form-control']); //Field
                                        echo Html::error($modelStock,"[{$i}]location_id", ['class' => 'help-block']); //error
                                        echo $form->field($modelStock, "[{$i}]location_id")->end();
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $form->field($modelStock, "[{$i}]quantity")->begin();
                                        echo Html::activeTextInput($modelStock, "[{$i}]quantity", ['maxlength' => true, 'class' => 'form-control']); //Field
                                        echo Html::error($modelStock,"[{$i}]quantity", ['class' => 'help-block']); //error
                                        echo $form->field($modelStock, "[{$i}]quantity")->end();
                                    ?>
                                </td>

                            </tr><!-- stock -->
                        <?php endforeach; // end of stock loop ?>
                        </tbody>
                        <tfoot>
                            <td colspan="3" class="active">
                                <button type="button" class="add-stock btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            </td>
                        </tfoot>
                    </table>
                    </div>
                    <?php DynamicFormWidget::end(); // end of stock widget ?>
                </div>  
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($modelProduct->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
                

    <?php ActiveForm::end(); ?>
</div>