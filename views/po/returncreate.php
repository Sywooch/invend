<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Po */

$this->title = Yii::t('app', 'Purchase Order Return');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Order List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-return-create">

    <?= $this->render('_returnform', [
        'modelPo' => $modelPo,
        'modelVendor' => $modelVendor,
        'modelsPoLines' => $modelsPoLines,
    ]) ?>

</div>
