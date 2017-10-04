<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesOrder */

$this->title = Yii::t('app', 'Sales Order Return');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Order Return List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-return-create">

    <?= $this->render('_form', [
        'modelSalesOrderReturn' => $modelSalesOrderReturn,
        'modelCustomer' => $modelCustomer,
        'modelsSalesOrderReturnLines' => $modelsSalesOrderReturnLines,
    ]) ?>

</div>
