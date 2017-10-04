<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Vendor;
use yii\helpers\ArrayHelper;
?>

<div class="po-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($modelPo, 'number') ?>

    <?= $form->field($modelPo, 'vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>

    <?= $form->field($modelPo, 'status')->dropDownList(['1'=>'Unreceived, Unpaid','2'=>'Received, Paid','3'=>'Received, Unpaid'],['prompt' => '','maxlength' => true, 'class' => 'form-control']) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
