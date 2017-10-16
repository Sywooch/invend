<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\models\Agreement;


/* @var $this yii\web\View */
/* @var $model app\models\Property */

$this->title = Yii::t('app', 'Property Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="property-form">

	    <?php $form = ActiveForm::begin(['id' => 'property-form']); ?>
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <i class="fa fa-envelope"></i> Property Form
	            <div class="clearfix"></div>
	        </div>
	        <div class="panel-body">
	            <div class="row">
	                <?= $form->field($model, 'user_id')->hiddenInput(['value'=> Yii::$app->user->getId()])->label(false) ?>

	                <div class="col-sm-6">
	                    <?= $form->field($model, 'property_id')->widget(Select2::classname(), [
	                        'data' => ArrayHelper::map(Agreement::find()->where(['active' => 1 ])->orderBy('tenant_name ASC')->all(), 'id', 'property.name'),
	                        'options' => ['placeholder' => 'Select a tenant ...', 'onchange' => 'getGoodwillSummary(this)'],
	                        'pluginOptions' => [
	                            'allowClear' => true
	                        ],
	                    ]) ?>
	                </div>

	            </div>

	            <div class="row">

	                <div class="col-sm-6">
	                   <?= $form->field($model, 'reason')->textarea(['rows' => 6])->hint('Optional') ?>
	                </div>

	            </div><!-- end:row -->

	        </div>
	    </div>

	     <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>
