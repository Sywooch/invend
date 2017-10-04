<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = Yii::t('app', 'Customer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <?= $this->render('_form', [
        'modelCustomer' => $modelCustomer,
    ]) ?>

</div>
