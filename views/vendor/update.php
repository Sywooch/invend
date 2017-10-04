<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vendor */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vendor List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelVendor->name, 'url' => ['view', 'id' => $modelVendor->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vendor-update">

    <?= $this->render('_form', [
        'modelVendor' => $modelVendor,
    ]) ?>

</div>
