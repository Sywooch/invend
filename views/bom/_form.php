<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use app\models\Uom;
use app\models\Product;
use yii\helpers\ArrayHelper;

?>

<div class="bom-form">

    <!-- The Bom Information    -->
    <?php $form = ActiveForm::begin(['id' => 'bom-form']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Bill of Materials </h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($modelBom, 'name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelBom, 'number')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($modelBom, 'description')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                </div>
                <div class="col-sm-3">
                    <p></p>
                    <p></p>
                    <br>
                    <?= $form->field($modelBom, 'active')->checkbox(array('label'=>'Enabled')) ?>
                </div>
            </div>
        </div>
        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
        <!-- The stages -->
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Details </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/bom/index">Bill List</a></li>
                        <li><a href="/product/create">New Product</a></li>
                    </ul>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1"> Stage / Components</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2">Output</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'stage_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-stages', // required: css class selector
                                        'widgetItem' => '.stage-item', // required: css class
                                        'insertButton' => '.add-stage', // css class
                                        'deleteButton' => '.del-stage', // css class
                                        'model' => $modelsStage[0],
                                        'formId' => 'bom-form',
                                        'formFields' => [
                                            'name',
                                            'total_input_cost',
                                        ],
                                    ]); ?>
                                    
                                    <div class="table-responsive">

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="active">
                                                <td></td>
                                                <td><?= Html::activeLabel($modelsStage[0], 'name'); ?></td>
                                                <td><?= Html::activeLabel($modelsStage[0], 'total_input_cost'); ?></td>
                                                <td><label class="control-label">Components</label></td>
                                            </tr>
                                        </thead>

                                        <tbody class="container-stages"><!-- widgetContainer -->
                                        <?php foreach ($modelsStage as $i => $modelStage): ?>
                                            <tr class="stage-item"><!-- widgetBody -->
                                                <td>
                                                    <button type="button" class="del-stage btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                                    <?php
                                                    // necessary for update action.
                                                    if (! $modelStage->isNewRecord) {
                                                        echo Html::activeHiddenInput($modelStage, "[{$i}]id");
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelStage, "[{$i}]name")->begin();
                                                        echo Html::activeTextInput($modelStage, "[{$i}]name", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelStage,"[{$i}]name", ['class' => 'help-block']); //error
                                                        echo $form->field($modelStage, "[{$i}]name")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelStage, "[{$i}]total_input_cost")->begin();
                                                        echo Html::activeTextInput($modelStage, "[{$i}]total_input_cost", ['readonly' => true, 'maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelStage,"[{$i}]total_input_cost", ['class' => 'help-block']); //error
                                                        echo $form->field($modelStage, "[{$i}]total_input_cost")->end();
                                                    ?>
                                                </td>

                                                <!-- The Components -->
                                                <td id="components">

                                                    <?php DynamicFormWidget::begin([
                                                        'widgetContainer' => 'component_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                                        'widgetBody' => '.container-components', // required: css class selector
                                                        'widgetItem' => '.component-item', // required: css class
                                                        'insertButton' => '.add-component', // css class
                                                        'deleteButton' => '.del-component', // css class
                                                        'model' => $modelsComponents[$i][0],
                                                        'formId' => 'bom-form',
                                                        'formFields' => [
                                                            'product_id',
                                                            'number',
                                                            'quantity_type',
                                                            'quantity',
                                                            'last_cost',
                                                            'uom_id',
                                                            'total_line_cost',
                                                            'remark',
                                                        ],
                                                    ]);

                                                    ?>

                                                    <div class="table-responsive">

                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr class="active">
                                                                <th></th>
                                                                <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'product_id'); ?></th>
                                                                <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'number'); ?></th>
                                                                <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'quantity_type'); ?></th>
                                                                <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'quantity'); ?></th>
                                                                <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'last_cost'); ?></th>
                                                                <th class="col-xs-2"><?= Html::activeLabel($modelsComponents[$i][0], 'uom_id'); ?></th>
                                                                <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'total_line_cost'); ?></th>
                                                                <th class="col-xs-1"><?= Html::activeLabel($modelsComponents[$i][0], 'remarks'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="container-components"><!-- widgetContainer -->
                                                        <?php foreach ($modelsComponents[$i] as $ix => $modelComponent): ?>
                                                            <tr class="component-item"><!-- widgetBody -->
                                                                <td>
                                                                    <button type="button" class="del-component btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                                                    <?php
                                                                    // necessary for update action.
                                                                    if (! $modelComponent->isNewRecord) {
                                                                        echo Html::activeHiddenInput($modelComponent, "[{$i}][{$ix}]id");
                                                                    }
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]product_id")->begin();
                                                                        echo Html::activeDropDownList($modelComponent, "[{$i}][{$ix}]product_id", ArrayHelper::map(Product::find()->all(), 'id', 'item_name'), ['prompt' => '','maxlength' => true, 'class' => 'form-control', 'onChange' => 'getComponentProduct(this)']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]product_id", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]product_id")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]number")->begin();
                                                                        echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]number", ['readonly' => true,'maxlength' => true, 'class' => 'form-control']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]number", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]number")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]quantity_type")->begin();
                                                                        echo Html::activeDropDownList($modelComponent, "[{$i}][{$ix}]quantity_type", ['1'=>'Ratio','2'=>'Fixed'],['prompt' => '','maxlength' => true, 'class' => 'form-control']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]quantity_type", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]quantity_type")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]quantity")->begin();
                                                                        echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]quantity", ['maxlength' => true, 'class' => 'form-control','onchange' => 'getSubTotal(this)']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]quantity", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]quantity")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]last_cost")->begin();
                                                                        echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]last_cost", ['readonly' => true,'maxlength' => true, 'class' => 'form-control','onchange' => 'getSubTotal(this)']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]last_cost", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]last_cost")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]uom_id")->begin();
                                                                        echo Html::activeDropDownList($modelComponent, "[{$i}][{$ix}]uom_id", ArrayHelper::map(Uom::find()->all(), 'id', 'name'), ['disabled' => true,'prompt' => '','maxlength' => true, 'class' => 'form-control']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]uom_id", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]uom_id")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]total_line_cost")->begin();
                                                                        echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]total_line_cost", ['readonly' => true,'maxlength' => true, 'class' => 'form-control','onchange' => 'getTotal(this);this.oldvalue = this.value;']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]total_line_cost", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]total_line_cost")->end();
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]remarks")->begin();
                                                                        echo Html::activeTextInput($modelComponent, "[{$i}][{$ix}]remarks", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                                        echo Html::error($modelComponent,"[{$i}][{$ix}]remarks", ['class' => 'help-block']); //error
                                                                        echo $form->field($modelComponent, "[{$i}][{$ix}]remarks")->end();
                                                                    ?>
                                                                </td>

                                                            </tr>
                                                            
                                                        <?php endforeach; // end of components loop ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <td colspan="7" class="active"><button type="button" class="add-component btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button></td>
                                                            <td colspan="1" class="active">

                                                                <?= Html::input('text', 'total_input_cost', $modelsStage[$i]->total_input_cost, ['id' => "bomstage-{$i}-total_input_cost",'readonly'=>true,'maxlength' => true, 'class' => 'form-control', 'onchange' => 'getGrandTotal(this);this.oldvalue = this.value;']); ?>
                                                                <?= Html::hiddenInput('count', $modelsStage[$i]->count, ['id' => "bomstage-{$i}-count",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                                            </td>
                                                            <td colspan="1" class="active"></td>
                                                        </tfoot>
                                                    </table>
                                                    </div>
                                                    <?php DynamicFormWidget::end(); // end of components widget ?>

                                                </td> <!-- components sub column -->
                                            </tr><!-- stage -->
                                        <?php endforeach; // end of stage loop ?>
                                        </tbody>
                                        <tfoot>
                                            <td colspan="3" class="active">
                                                <button type="button" class="add-stage btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            </td>
                                            <td colspan="1" class="active">
                                                <?= Html::input('text', 'total_input_cost', $modelBom->total_input_cost, ['id' => "bom-total_input_cost",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                                <?= Html::hiddenInput('count', $modelBom->count, ['id' => "bom-count",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                            </td>
                                        </tfoot>
                                    </table>
                                    </div>
                                    <?php DynamicFormWidget::end(); // end of stage widget ?>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <?php DynamicFormWidget::begin([
                                        'widgetContainer' => 'output_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                        'widgetBody' => '.container-outputs', // required: css class selector
                                        'widgetItem' => '.output-item', // required: css class
                                        'insertButton' => '.add-output', // css class
                                        'deleteButton' => '.del-output', // css class
                                        'model' => $modelsOutput[0],
                                        'formId' => 'bom-form',
                                        'formFields' => [
                                            'product_id',
                                            'number',
                                            'quantity_type',
                                            'quantity',
                                            'uom_id',
                                            'last_cost',
                                            'cost',
                                            'cost_percentage',
                                            'remarks',
                                            'primary',
                                        ],
                                    ]); ?>
                                    
                                    <div class="table-responsive">

                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="active">
                                                <td></td>
                                                <td class="col-xs-2"><?= Html::activeLabel($modelsOutput[0], 'product_id'); ?></td>
                                                <td class="col-xs-2"><?= Html::activeLabel($modelsOutput[0], 'number'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'quantity_type'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'quantity'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'uom_id'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'last_cost'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'cost'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'cost_percentage'); ?></td>
                                                <td class="col-xs-2"><?= Html::activeLabel($modelsOutput[0], 'remarks'); ?></td>
                                                <td class="col-xs-1"><?= Html::activeLabel($modelsOutput[0], 'primary'); ?></td>
                                            </tr>
                                        </thead>

                                        <tbody class="container-outputs"><!-- widgetContainer -->
                                        <?php foreach ($modelsOutput as $i => $modelOutput): ?>
                                            <tr class="output-item"><!-- widgetBody -->
                                                <td>
                                                    <button type="button" class="del-output btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                                    <?php
                                                    // necessary for update action.
                                                    if (! $modelOutput->isNewRecord) {
                                                        echo Html::activeHiddenInput($modelOutput, "[{$i}]id");
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]product_id")->begin();
                                                        echo Html::activeDropDownList($modelOutput, "[{$i}]product_id", ArrayHelper::map(Product::find()->all(), 'id', 'item_name'), ['prompt' => '','maxlength' => true, 'class' => 'form-control', 'onChange' => 'getOutputProduct(this)']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]product_id", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]product_id")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]number")->begin();
                                                        echo Html::activeTextInput($modelOutput, "[{$i}]number", ['readonly' => true,'maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]number", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]number")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]quantity_type")->begin();
                                                        echo Html::activeDropDownList($modelOutput, "[{$i}]quantity_type", ['1'=>'Ratio','2'=>'Fixed'],['prompt' => '','maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]quantity_type", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]quantity_type")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]quantity")->begin();
                                                        echo Html::activeTextInput($modelOutput, "[{$i}]quantity", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]quantity", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]quantity")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]uom_id")->begin();
                                                        echo Html::activeDropDownList($modelOutput, "[{$i}]uom_id", ArrayHelper::map(Uom::find()->all(), 'id', 'name'), ['disabled' => true,'prompt' => '','maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]uom_id", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]uom_id")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]last_cost")->begin();
                                                        echo Html::activeTextInput($modelOutput, "[{$i}]last_cost", ['readonly' => true,'maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]last_cost", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]last_cost")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]cost")->begin();
                                                        echo Html::activeTextInput($modelOutput, "[{$i}]cost", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]cost", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]cost")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]cost_percentage")->begin();
                                                        echo Html::activeTextInput($modelOutput, "[{$i}]cost_percentage", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]cost_percentage", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]cost_percentage")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]remarks")->begin();
                                                        echo Html::activeTextInput($modelOutput, "[{$i}]remarks", ['maxlength' => true, 'class' => 'form-control']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]remarks", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]remarks")->end();
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        echo $form->field($modelOutput, "[{$i}]primary")->begin();
                                                        echo Html::activeCheckBox($modelOutput, "[{$i}]primary", ['label'=>'']); //Field
                                                        echo Html::error($modelOutput,"[{$i}]primary", ['class' => 'help-block']); //error
                                                        echo $form->field($modelOutput, "[{$i}]primary")->end();
                                                    ?>
                                                </td>
                                            </tr><!-- output -->
                                        <?php endforeach; // end of output loop ?>
                                        </tbody>
                                        <tfoot>
                                            <td colspan="12" class="active">
                                                <button type="button" class="add-output btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            </td>
                                        </tfoot>
                                    </table>
                                    </div>
                                    <?php DynamicFormWidget::end(); // end of payment widget ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($modelBom->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
                

    <?php ActiveForm::end(); ?>
   
    
</div>

<script>
    // Get Product Info
    function getComponentProduct(component) {

      console.log('component');
      console.log(component);
      console.log(component.id);
      console.log(component.value);
      
      var product_id = component.value;
      var input = component.id;
      var fields = input.split('-');
      console.log(fields);

      var index_1 = fields[1];
      var index_2 = fields[2];
      var name = fields[3];

      console.log('product_id');
      console.log(product_id);

      if(product_id != undefined && product_id != 0 && product_id != null && !isNaN(product_id))
      {
        $.ajax({
          url: '/product/get-product-info',
          data: {id: product_id },
          success: function(data) {
            if (data)
            {
              var product = JSON.parse(data);
              console.log('product');
              console.log(product);
              console.log(product.item_code);
              var txtnumber = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-number');
              txtnumber.value= product.item_code;

              var txtlast_cost = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-last_cost');
              txtlast_cost.value= product.cost;

              var txtuom_id = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-uom_id');
              txtuom_id.value= product.standard_uom_id;

            }else {
              alert('No Data');
            }
            return true;
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
              $.ajax({
                url: '/product/get-product-info',
                data: {id: product_id },
                success: function(data) {
                    if (data)
                    {
                      var product = JSON.parse(data);
                      console.log('product');
                      console.log(product);
                      console.log(product.item_code);
                      var txtnumber = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-number');
                      txtnumber.value= product.item_code;

                      var txtlast_cost = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-last_cost');
                      txtlast_cost.value= product.cost;

                      var txtuom_id = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-uom_id');
                      txtuom_id.value= product.standard_uom_id;

                    }else {
                      alert('No Data');
                    }
                    return true;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown); 
                }     

              }); 
          }
        });
      }
    }


    // Get Product Info
    function getOutputProduct(component) {

      console.log('component');
      console.log(component);
      console.log(component.id);
      console.log(component.value);
      
      var product_id = component.value;
      var input = component.id;
      var fields = input.split('-');

      var index_1 = fields[1];
      var name = fields[3];

      console.log('product_id');
      console.log(product_id);

      if(product_id != undefined && product_id != 0 && product_id != null && !isNaN(product_id))
      {
        $.ajax({
          url: '/product/get-product-info',
          data: {id: product_id },
          success: function(data) {
            if (data)
            {
              var product = JSON.parse(data);
              console.log('product');
              console.log(product);
              console.log(product.item_code);
              var txtnumber = document.getElementById('bomoutputs-' +  index_1 + '-number');
              txtnumber.value= product.item_code;

              var txtlast_cost = document.getElementById('bomoutputs-' +  index_1 + '-last_cost');
              txtlast_cost.value= product.cost;

              var txtuom_id = document.getElementById('bomoutputs-' +  index_1 + '-uom_id');
              txtuom_id.value= product.standard_uom_id;

            }else {
              alert('No Data');
            }
            return true;
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
              $.ajax({
                url: '/product/get-product-info',
                data: {id: product_id },
                success: function(data) {
                    if (data)
                    {
                      var product = JSON.parse(data);
                      console.log('product');
                      console.log(product);
                      console.log(product.item_code);
                      var txtnumber = document.getElementById('bomoutputs-' +  index_1 + '-number');
                      txtnumber.value= product.item_code;

                      var txtlast_cost = document.getElementById('bomoutputs-' +  index_1 + '-last_cost');
                      txtlast_cost.value= product.cost;

                      var txtuom_id = document.getElementById('bomoutputs-' +  index_1 + '-uom_id');
                      txtuom_id.value= product.standard_uom_id;

                    }else {
                      alert('No Data');
                    }
                    return true;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown); 
                }     

              }); 
          }
        });
      }
    }
</script>

<?php
$js = <<<'EOD'

    $(function () {
        $(".component_wrapper").on("afterInsert", function(e, item) {
            console.log(e);
            console.log(item);

            count = parseFloat($('#bomstage-count').val());
            count = parseFloat(count);
            console.log(count);
            if(isNaN(count))
            {
                count = 0;
            }

            // inital count is the same as index_1
            var txtproduct = document.getElementById('bomcomponents-' +  count + '-product_id');
            txtproduct.value= 0;

            count = count + 1;
            console.log("count");
            console.log(count);
            
            var txtcount = document.getElementById('bomstage-count');
            txtcount.value= count;

        });

        $(".component_wrapper").on("afterDelete", function(e, item) {
        
            count = parseFloat($('#po_line-count').val());
            count = parseFloat(count);
            console.log(count);
            if(isNaN(count))
            {
                count = 0;
            }

            count = count - 1;
            console.log("count");
            console.log(count);
            console.log(e);
            console.log(item);

            var txtcount = document.getElementById('po_line-count');
            txtcount.value= count;

        });

        $(".stage_wrapper").on("afterInsert", function(e, item) {

            count = parseFloat($('#po_line-count').val());
            count = parseFloat(count);
            console.log(count);
            if(isNaN(count))
            {
                count = 0;
            }

            // inital count is the same as index_1
            var txtproduct = document.getElementById('polines-' +  count + '-product_id');
            txtproduct.value= 0;

            count = count + 1;
            console.log("count");
            console.log(count);
            console.log(e);
            console.log(item);

            var txtcount = document.getElementById('po_line-count');
            txtcount.value= count;

        });

        $(".stage_wrapper").on("afterDelete", function(e, item) {
        
            count = parseFloat($('#po_line-count').val());
            count = parseFloat(count);
            console.log(count);
            if(isNaN(count))
            {
                count = 0;
            }

            count = count - 1;
            console.log("count");
            console.log(count);
            console.log(e);
            console.log(item);

            var txtcount = document.getElementById('po_line-count');
            txtcount.value= count;

        });
    });


//    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
//        for kartik datepicker
//        var datePickers = $(this).find('[data-krajee-kvdatepicker]');
//        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker('remove');
//            $(this).parent().kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
//        });

//      for jui datepicker
//        $( ".picker" ).each(function() {
//           $(this).datepicker({
//              dateFormat : "d-m-Y",
//              yearRange : "1925:+0",
//              maxDate : "-1D",
//              changeMonth: true,
//              changeYear: true
//           });
//        });          
//    });
    
    $(".dynamicform_wrapper").on("afterDelete", function(e, item) {
        $( ".picker" ).each(function() {
           $( this ).removeClass("hasDatepicker").datepicker({
              dateFormat : "dd-M-yyyy",
              yearRange : "1925:+0",
              maxDate : "-1D",
              changeMonth: true,
              changeYear: true
           });
        });   
        
        jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
            jQuery(this).html("Contact: " + (index + 1))
        });
    });


EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>