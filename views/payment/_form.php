<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Agreement;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use borales\extensions\phoneInput\PhoneInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin([
    'id' => 'payment-form','options'=>['enctype'=>'multipart/form-data']]); // important 
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Payment Form
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-sm-3">
                    <?= $form->field($model, 'agreement_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Agreement::find()->orderBy('tenant_name ASC')->all(), 'id', 'property.name'),
                        'options' => ['placeholder' => 'Select a tenant ...', 'onchange' => 'getGoodwillSummary(this)'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'type')->dropDownList(['Goodwill'=>'Goodwill','Rent'=>'Rent'],['prompt' => '']) ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model,'date')->widget(DatePicker::className(),[
                        'dateFormat' => 'dd-MM-yyyy',

                        'clientOptions' => [
                            'todayHighlight' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'maxDate' => '0',
                            'minDate'=>'0',
                            'defaultDate' => '-0d',
                        ],
                        'clientEvents' => [
                            'changeDate' => false
                        ],
                        'options' => [
                            'readonly' => 'readonly'
                        ]
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <label>Amount Paid</label>
                    <div class="input-group">
                        <span id = "payment-currency_amount_paid" class="input-group-addon">$</span>
                        <?= $form->field($model, 'amount_paid')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'receipt_number')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'mode')->dropDownList(['Cheque'=>'Cheque','Cash'=>'Cash']) ?>
                </div> 

            </div><!-- end:row -->

            <div class="row">

                <div class="col-sm-6">
                    <?= $form->field($modelDocument, 'image')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],'showUpload' => false,],
                    ]);?>
                </div>  
                
                <div class="col-sm-6">
                    <?= $form->field($model, 'notes')->textarea(['rows' => 6])->hint('Mandatory') ?>
                </div>   

            </div><!-- end:row -->

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Balance Information Form
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

            <div class="row">

                <div class="col-sm-3">
                    <label>Total Rent Paid</label>
                    <?= Html::input('text', 'total_rent_paid', $total_rent_paid, ['class' => 'form-control', 'disabled' => true, 'id' => 'payment-total_rent_paid']); ?>
                </div>

                <div class="col-sm-3">
                    <label>Total Rent Arrears</label>
                    <?= Html::input('text', 'total_rent_arrears', $total_rent_arrears, ['class' => 'form-control', 'disabled' => true, 'id' => 'payment-total_rent_arrears']); ?>
                </div>

                <div class="col-sm-3">
                    <label>Total Goodwill Paid</label>
                    <?= Html::input('text', 'total_goodwill_paid', $total_goodwill_paid, ['class' => 'form-control', 'disabled' => true, 'id' => 'payment-total_goodwill_paid']); ?>
                </div>

                <div class="col-sm-3">
                    <label>Total Goodwill Arrears</label>
                    <?= Html::input('text', 'total_goodwill_arrears', $total_goodwill_arrears, ['class' => 'form-control', 'disabled' => true, 'id' => 'payment-total_goodwill_arrears']); ?>
                </div>

            </div><!-- end:row -->
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Contact Information Form
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

            <div class="row">

                <div class="col-sm-3">
                    <?= $form->field($model, 'payee_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'payee_mobile_number')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'payee_email')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'payee_address')->textInput(['maxlength' => true]) ?>
                </div>

            </div><!-- end:row -->
        </div>
    </div>

    <div id="hiddenDiv" class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Bank Information Form
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">

            <div class="row">

                <div class="col-sm-3">
                    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'cheque_number')->textInput(['maxlength' => true]) ?>
                </div>

            </div>

        </div>
    </div>

     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

$(document).ready(function () {

    $(document.body).on('change', '#payment-mode', function () {
        var val = $('#payment-mode').val();
        if(val == 'Cheque' ) {
          $('#hiddenDiv').show();
        } else {
          $('#hiddenDiv').hide();
        }
    });
});

JS;
$this->registerJs($script);
?>