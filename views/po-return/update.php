<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PoReturn */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Order Return'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelPoReturn->id, 'url' => ['view', 'id' => $modelPoReturn->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'update');
?>
<div class="po-update">

    <?= $this->render('_form', [
        'modelPoReturn' => $modelPoReturn,
        'modelVendor' => $modelVendor,
        'modelsPoReturnLines' => $modelsPoReturnLines,
    ]) ?>

</div>
