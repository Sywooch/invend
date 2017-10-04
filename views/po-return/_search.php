<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Vendor;
use yii\helpers\ArrayHelper;

?>

<div class="po-return-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($modelPoReturn, 'number') ?>

    <?= $form->field($modelPoReturn, 'vendor_id')->dropDownList(ArrayHelper::map(Vendor::find()->where(['active' => 1 ])->orderBy('name ASC')->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>

    <?= $form->field($modelPoReturn, 'status')->dropDownList(['4'=>'Unreturned, Unpaid','5'=>'Returned, Unpaid','6'=>'Returned, Paid'],['prompt' => '', 'maxlength' => true, 'class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
