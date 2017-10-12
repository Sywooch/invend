<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Po */

$this->title = Yii::t('app', 'Purchase Return');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Return List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-return-create">

    <?= $this->render('_form', [
        'modelPoReturn' => $modelPoReturn,
        'modelVendor' => $modelVendor,
        'modelsPoReturnLines' => $modelsPoReturnLines,
    ]) ?>

</div>
