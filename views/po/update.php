<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Po */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelPo->id, 'url' => ['view', 'id' => $modelPo->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'update');
?>
<div class="po-update">

    <?= $this->render('_form', [
        'modelPo' => $modelPo,
        'modelVendor' => $modelVendor,
        'modelsPoLines' => $modelsPoLines,
    ]) ?>

</div>
