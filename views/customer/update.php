<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelCustomer->name, 'url' => ['view', 'id' => $modelCustomer->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="customer-update">

    <?= $this->render('_form', [
        'modelCustomer' => $modelCustomer,
    ]) ?>

</div>
