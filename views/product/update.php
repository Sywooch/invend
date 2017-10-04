<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelProduct->id, 'url' => ['view', 'id' => $modelProduct->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'modelProduct' => $modelProduct,
        'modelsStock'  => $modelsStock,
    ]) ?>

</div>
