<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use app\models\Uom;
use app\models\Product;
use app\models\Customer;
use app\models\Location;
use app\models\Currency;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;

?>

<div class="sales-order-return-form">

    <!-- The Bom Information    -->
    <?php $form = ActiveForm::begin(['id' => 'sales-order-return-form']); ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Sales Order </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/sales-order/create">Sales Order</a></li>
                        <li><a href="/sales-order/index">Sales Order List</a></li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-2">
                        <?= $form->field($modelSalesOrderReturn, 'customer_id')->dropDownList(ArrayHelper::map(Customer::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control', 'onChange' => 'getCustomer(this)']) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($modelCustomer, 'contact')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($modelCustomer, 'phone')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelCustomer, 'address')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelSalesOrderReturn, 'date')->widget(DatePicker::classname(),[
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
                        <li><a href="/customer/create">Customer</a></li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'sales_order_return_line_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-sales_order_return_lines', // required: css class selector
                            'widgetItem' => '.sales_order_return_line-item', // required: css class
                            'insertButton' => '.add-sales_order_return_line', // css class
                            'deleteButton' => '.del-sales_order_return_line', // css class
                            'model' => $modelsSalesOrderReturnLines[0],
                            'formId' => 'sales-order-return-form',
                            'formFields' => [
                                'product_id',
                                'quantity',
                                'unit_price',
                                'sub_total',
                            ],
                        ]); ?>
                        
                        <div class="table-responsive">

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="active">
                                    <td></td>
                                    <td class="col-xs-4"><?= Html::activeLabel($modelsSalesOrderReturnLines[0], 'product_id'); ?></td>
                                    <td class="col-xs-3"><?= Html::activeLabel($modelsSalesOrderReturnLines[0], 'quantity'); ?></td>
                                    <td class="col-xs-3"><?= Html::activeLabel($modelsSalesOrderReturnLines[0], 'unit_price'); ?></td>
                                    <td class="col-xs-2"><?= Html::activeLabel($modelsSalesOrderReturnLines[0], 'sub_total'); ?></td>
                                </tr>
                            </thead>

                            <tbody class="container-sales_order_return_lines"><!-- widgetContainer -->
                            <?php foreach ($modelsSalesOrderReturnLines as $i => $modelSalesOrderReturnLine): ?>
                                <tr class="sales_order_return_line-item"><!-- widgetBody -->
                                    <td>
                                        <button type="button" class="del-sales_order_return_line btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        <?php
                                        // necessary for update action.
                                        if (! $modelSalesOrderReturnLine->isNewRecord) {
                                            echo Html::activeHiddenInput($modelSalesOrderReturnLine, "[{$i}]id");
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]product_id")->begin();
                                            echo Html::activeDropDownList($modelSalesOrderReturnLine, "[{$i}]product_id", ArrayHelper::map(Product::find()->where(['active' => 1, 'product_category_id' => 2 ])->orderBy('item_name ASC')->all(), 'id', 'item_name'), ['prompt' => "",'maxlength' => true, 'class' => 'form-control', 'onChange' => 'getProduct(this)']); //Field
                                            echo Html::error($modelSalesOrderReturnLine,"[{$i}]product_id", ['class' => 'help-block']); //error
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]product_id")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]quantity")->begin();
                                            echo Html::activeTextInput($modelSalesOrderReturnLine, "[{$i}]quantity", ['maxlength' => true, 'class' => 'form-control','onchange' => 'getSoReturnSubTotal(this)']); //Field
                                            echo Html::error($modelSalesOrderReturnLine,"[{$i}]quantity", ['class' => 'help-block']); //error
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]quantity")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]unit_price")->begin();
                                            echo Html::activeTextInput($modelSalesOrderReturnLine, "[{$i}]unit_price", ['maxlength' => true, 'class' => 'form-control','onchange' => 'getSoReturnSubTotal(this)']); //Field
                                            echo Html::error($modelSalesOrderReturnLine,"[{$i}]unit_price", ['class' => 'help-block']); //error
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]unit_price")->end();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]sub_total")->begin();
                                            echo Html::activeTextInput($modelSalesOrderReturnLine, "[{$i}]sub_total", ['readonly' => true,'maxlength' => true, 'class' => 'form-control','onchange' => 'getSoReturnTotal(this);this.oldvalue = this.value;']); //Field
                                            echo Html::error($modelSalesOrderReturnLine,"[{$i}]sub_total", ['class' => 'help-block']); //error
                                            echo $form->field($modelSalesOrderReturnLine, "[{$i}]sub_total")->end();
                                        ?>
                                    </td>
                                </tr><!-- sales_order_return_line -->
                            <?php endforeach; // end of sales_order_return_line loop ?>
                            </tbody>
                            <tfoot>
                                <td colspan="4" class="active">
                                    <button type="button" class="add-sales_order_return_line btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                </td>
                                <td colspan="1" class="active">
                                    <?= Html::input('text', 'sub_total', $modelSalesOrderReturn->total, ['id' => "so_return_line-sub_total",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                    <?= Html::hiddenInput('count', $modelSalesOrderReturn->count, ['id' => "so_return_line-count",'readonly'=>true,'maxlength' => true, 'class' => 'form-control']); ?>
                                </td>
                            </tfoot>
                        </table>
                        </div>
                        <?php DynamicFormWidget::end(); // end of sales_order_return_line widget ?>
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
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($modelSalesOrderReturn, 'paid')->textInput(['maxlength' => true, 'class' => 'form-control', 'onchange' => 'getSoReturnBalance(this)']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelSalesOrderReturn, 'balance')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelSalesOrderReturn, 'total')->textInput(['readonly' => true,'maxlength' => true, 'class' => 'form-control', 'onChange' => 'getSoReturnBalance(this)']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($modelSalesOrderReturn, 'due_date')->widget(DatePicker::classname(),[
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

            </div>
        </div>
        <div class="padding-v-md">
            <div class="line line-dashed"></div>
        </div>
    
        <div class="form-group">
            <?= Html::submitButton($modelSalesOrderReturn->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
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

              var txtlast_cost = document.getElementById('salesorderreturnlines-' +  index_1 + '-unit_price');
              txtlast_cost.value= product.cost;


              $('#salesorderreturnlines-' +  index_1 + '-unit_price').val(product.cost).trigger('change');

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

                      var txtlast_cost = document.getElementById('salesorderreturnlines-' +  index_1 + '-unit_price');
                      txtlast_cost.value= product.cost;

                      $('#salesorderreturnlines-' +  index_1 + '-unit_price').val(product.cost).trigger('change');

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

        $(".sales_order_return_line_wrapper").on("afterInsert", function(e, item) {

            count = parseFloat($('#so_return_line-count').val());
            count = parseFloat(count);
            console.log(count);
            if(isNaN(count))
            {
                count = 0;
            }

            // inital count is the same as index_1
            var txtproduct = document.getElementById('salesorderreturnlines-' +  count + '-product_id');
            txtproduct.value= 0;

            count = count + 1;
            console.log("count");
            console.log(count);
            console.log(e);
            console.log(item);

            var txtcount = document.getElementById('so_return_line-count');
            txtcount.value= count;

        });

        $(".sales_order_return_line_wrapper").on("afterDelete", function(e, item) {
        
            count = parseFloat($('#so_return_line-count').val());
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

            var txtcount = document.getElementById('so_return_line-count');
            txtcount.value= count;

        });
    });


EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>