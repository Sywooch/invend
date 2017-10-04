<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Po */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelSalesOrderReturn->id, 'url' => ['view', 'id' => $modelSalesOrderReturn->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'update');
?>
<div class="sales-order-return-update">

    <?= $this->render('_form', [
        'modelSalesOrderReturn' => $modelSalesOrderReturn,
        'modelCustomer' => $modelCustomer,
        'modelsSalesOrderReturnLines' => $modelsSalesOrderReturnLines,
    ]) ?>

</div>
