<?php

use yii\web\View;

/* @var $this View */
/* @var $titles DataTitles */
/* @var $model app\models\fs\Account */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product'), 'url' => ['create']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-create">

    <?= $this->render('_form', [
        'modelProduct' => $modelProduct,
        'modelsStock'  => $modelsStock,
    ]) ?>

</div>