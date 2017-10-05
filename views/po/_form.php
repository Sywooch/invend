<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use app\models\Uom;
use app\models\Product;
use app\models\Vendor;
use app\models\Location;
use app\models\Currency;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;


?>

<div class="po-form">

    <!-- The Bom Information    -->
    <?php $form = ActiveForm::begin(['id' => 'po-form']); ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Purchase Order </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/po/return-create">Purchase Order Return</a></li>
                        <li><a href="/po/index">Purchase Order List</a></li>
                    </ul>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control', 'onChange' => 'getVendor(this)']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelVendor, 'contact')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelVendor, 'phone')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelVendor, 'address')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'location_id')->dropDownList(ArrayHelper::map(Location::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'number')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'date')->widget(DatePicker::classname(),[
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

                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'status')->dropDownList(['1'=>'Unreceived, Unpaid','2'=>'Received, Paid','3'=>'Received, Unpaid'],['disabled' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Items </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/product/create">Product</a></li>
                        <li><a href="/product/index">Product List</a></li>
                    </ul>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'po_line_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-po_lines', // required: css class selector
                            'widgetItem' => '.po_line-item', // required: css class
                            'insertButton' => '.add-po_line', // css class
                            'deleteButton' => '.del-po_line', // css class
                            'model' => $modelsPoLines[0],
                            'formId' => 'po-form',
                            'formFields' => [
                                'product_id',
                                'item_code',
                                'quantity',
                                'unit_price',
                                'discount',
                                'sub_total',
                            ],
                        ]); ?>
                        
                        <div class="table-responsive">

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="active">
                                    <td></td>
                                    <td class="col-xs-4"><?= Html::activeLabel($modelsPoLines[0], 'product_id'); ?></td>
                                    <td class="col-xs-4"><?= Html::activeLabel($modelsPoLines[0], 'item_code'); ?></td>
                                    <td class="col-xs-1"><?= Html::activeLabel($modelsPoLines[0], 'quantity'); ?></td>
                                    <td class="col-xs-1"><?= Html::activeLabel($modelsPoLines[0], 'unit_price'); ?></td>
                                    <td class="col-xs-1"><?= Html::activeLabel($modelsPoLines[0], 'discount'); ?></td>
                                    <td class="col-xs-1"><?= Html::activeLabel($modelsPoLines[0], 'sub_total'); ?></td>
                                </tr>
                            </thead>

                            <tbody class="container-po_lines"><!-- widgetContainer -->
                            <?php foreach ($modelsPoLines as $i => $modelPoLine): ?>
                                <tr class="po_line-item"><!-- widgetBody -->
                                    <td>
                                        <button type="button" class="del-po_line btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        <?php
                                        // necessary for update action.
                                        if (! $modelPoLine->isNewRecord) {
                                            echo Html::activeHiddenInput($modelPoLine, "[{$i}]id");
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelPoLine, "[{$i}]product_id")->begin();
                                            echo Html::activeDropDownList($modelPoLine, "[{$i}]product_id", ArrayHelper::map(Product::find()->where(['active' => 1 ])->orderBy('item_name ASC')->all(), 'id', 'item_name'), ['prompt' => "",'maxlength' => true, 'class' => 'form-control', 'onChange' => 'getProduct(this)']); //Field
                                            echo Html::error($modelPoLine,"[{$i}]product_id", ['class' => 'help-block']); //error
                                            echo $form->field($modelPoLine, "[{$i}]product_id")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelPoLine, "[{$i}]item_code")->begin();
                                            echo Html::activeTextInput($modelPoLine, "[{$i}]item_code", ['maxlength' => true, 'class' => 'form-control']); //Field
                                            echo Html::error($modelPoLine,"[{$i}]item_code", ['class' => 'help-block']); //error
                                            echo $form->field($modelPoLine, "[{$i}]item_code")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelPoLine, "[{$i}]quantity")->begin();
                                            echo Html::activeTextInput($modelPoLine, "[{$i}]quantity", ['maxlength' => true, 'class' => 'form-control','onchange' => 'getPoSubTotal(this)']); //Field
                                            echo Html::error($modelPoLine,"[{$i}]quantity", ['class' => 'help-block']); //error
                                            echo $form->field($modelPoLine, "[{$i}]quantity")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelPoLine, "[{$i}]unit_price")->begin();
                                            echo Html::activeTextInput($modelPoLine, "[{$i}]unit_price", ['maxlength' => true, 'class' => 'form-control','onchange' => 'getPoSubTotal(this)']); //Field
                                            echo Html::error($modelPoLine,"[{$i}]unit_price", ['class' => 'help-block']); //error
                                            echo $form->field($modelPoLine, "[{$i}]unit_price")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelPoLine, "[{$i}]discount")->begin();
                                            echo Html::activeTextInput($modelPoLine, "[{$i}]discount", ['defaultValue' => 0, 'maxlength' => true, 'class' => 'form-control']); //Field
                                            echo Html::error($modelPoLine,"[{$i}]discount", ['class' => 'help-block']); //error
                                            echo $form->field($modelPoLine, "[{$i}]discount")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelPoLine, "[{$i}]sub_total")->begin();
                                            echo Html::activeTextInput($modelPoLine, "[{$i}]sub_total", ['readonly' => true,'maxlength' => true, 'class' => 'form-control','onchange' => 'getPoTotal(this);this.oldvalue = this.value;']); //Field
                                            echo Html::error($modelPoLine,"[{$i}]sub_total", ['class' => 'help-block']); //error
                                            echo $form->field($modelPoLine, "[{$i}]sub_total")->end();
                                        ?>
                                    </td>
                                </tr><!-- po_line -->
                            <?php endforeach; // end of po_line loop ?>
                            </tbody>
                            <tfoot>
                                <td colspan="6" class="active">
                                    <button type="button" class="add-po_line btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                                <td colspan="1" class="active">
                                    <?= Html::input('text', 'sub_total', $modelPo->total, ['id' => "po_line-sub_total",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                    <?= Html::hiddenInput('count', $modelPo->count, ['id' => "po_line-count",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                </td>
                            </tfoot>
                        </table>
                        </div>
                        <?php DynamicFormWidget::end(); // end of stage widget ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Extra Info </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'paid')->textInput(['maxlength' => true, 'class' => 'form-control', 'onchange' => 'getPoBalance(this)']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'balance')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'total')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control', 'onChange' => 'getPoBalance(this)']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'currency_id')->dropDownList(ArrayHelper::map(Currency::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'due_date')->widget(DatePicker::classname(),[
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
                    <div class="col-sm-3">
                        <?= $form->field($modelPo, 'remarks')->textarea(['rows' => 6])->hint('Optional') ?>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
    
        <div class="form-group">
            <?= Html::submitButton($modelPo->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
   
</div>

<script>

    // Get Product Info
    function getProduct(component) {

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

              var txtnumber = document.getElementById('polines-' +  index_1 + '-item_code');
              txtnumber.value= product.item_code;

              var txtlast_cost = document.getElementById('polines-' +  index_1 + '-unit_price');
              txtlast_cost.value= product.cost;


              $('#polines-' +  index_1 + '-unit_price').val(product.cost).trigger('change');

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
                      var txtnumber = document.getElementById('polines-' +  index_1 + '-item_code');
                      txtnumber.value= product.item_code;

                      var txtlast_cost = document.getElementById('polines-' +  index_1 + '-unit_price');
                      txtlast_cost.value= product.cost;

                      $('#polines-' +  index_1 + '-unit_price').val(product.cost).trigger('change');

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

        $(".po_line_wrapper").on("afterInsert", function(e, item) {

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

        $(".po_line_wrapper").on("afterDelete", function(e, item) {
        
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

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>