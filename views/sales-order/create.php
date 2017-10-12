<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesOrder */

$this->title = Yii::t('app', 'Sales');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-create">

    <?= $this->render('_form', [
        'modelSalesOrder' => $modelSalesOrder,
        'modelCustomer' => $modelCustomer,
        'modelsSalesOrderLines' => $modelsSalesOrderLines,
    ]) ?>

</div>
