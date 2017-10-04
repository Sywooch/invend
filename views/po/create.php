<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Po */

$this->title = Yii::t('app', 'Purchase Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Order List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-create">

    <?= $this->render('_form', [
        'modelPo' => $modelPo,
        'modelVendor' => $modelVendor,
        'modelsPoLines' => $modelsPoLines,
    ]) ?>

</div>
