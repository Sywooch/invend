<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Po */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelSalesOrder->id, 'url' => ['view', 'id' => $modelSalesOrder->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'update');
?>
<div class="sales-order-update">

    <?= $this->render('_form', [
        'modelSalesOrder' => $modelSalesOrder,
        'modelCustomer' => $modelCustomer,
        'modelsSalesOrderLines' => $modelsSalesOrderLines,
    ]) ?>

</div>
