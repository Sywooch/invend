<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Property;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Agreement */
/* @var $form yii\widgets\ActiveForm */

$prefix = '';
?>

<div class="agreement-form">

    <?php $form = ActiveForm::begin(['id' => 'agreement-form']); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Agreement Form
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>
            <div class="row">

                <div class="col-sm-3">
                    <?= $form->field($model, 'tenant_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'property_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Property::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Select a property ...', 'onchange' => "getPropertyType(this)"],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>

                <div class="col-sm-3">

                    <?= $form->field($model,'rent_start_date')->widget(DatePicker::className(),[
                        'language' => 'en',
                        'dateFormat' => 'dd-MM-yyyy',
                        'clientOptions' => [
                            'todayHighlight' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
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
                    <?= $form->field($model, 'goodwill_duration')->textInput(['maxlength' => true, 'placeholder' => 'years']) ?>
                </div>

                <div class="col-sm-3">
                    <label>Goodwill Amount</label>
                    <div class="input-group">
                        <span id = "agreement-currency_goodwill" class="input-group-addon">$</span>
                        <?= $form->field($model, 'goodwill')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model,'goodwill_start_date')->widget(DatePicker::className(),[
                        'dateFormat' => 'dd-MM-yyyy',

                        'clientOptions' => [
                            'todayHighlight' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'clientEvents' => [
                            'changeDate' => false
                        ],
                        'options' => [
                            'readonly' => 'readonly'
                        ]
                    ]); ?>

                </div>

            </div><!-- end:row -->

            <div class="row">

                <div class="col-sm-3">
                    <label>Rent Amount</label>
                    <div class="input-group">
                        <span id = "agreement-currency_rent_amount" class="input-group-addon">$</span>
                        <?= $form->field($model, 'rent_amount')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="col-sm-3">
                    <?= $form->field($model, 'frequency')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($model, 'notes')->textarea(['rows' => 6])->hint('Optional') ?>
                </div>     
            </div><!-- end:row -->
        </div>
    </div>

     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php

// $script = <<< JS

//     $('#agreement-property_id').change(function(){
//         var property_id = $(this).val();
//         $.get('../property/get', { id : property_id } , function(data){
//             alert(data.name);
//             $('#agreement-goodwill_duration').attr('value', 1);
//         });
//     });
// JS;

// $position = \yii\web\View::POS_READY;
// $this->registerJs($script, $position);
?>
