<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProductType;
use app\models\ProductCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'item_name') ?>

    <?= $form->field($model, 'product_category_id')->dropDownList(ArrayHelper::map(ProductCategory::find()->all(), 'id', 'name'),['prompt' => '', 'class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
