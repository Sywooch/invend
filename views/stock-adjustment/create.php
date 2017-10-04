<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StockAdjustment */

$this->title = Yii::t('app', 'Create Stock Adjustment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stock Adjustments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-adjustment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
