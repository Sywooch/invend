<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DistributionReturn */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Distribution Return',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distribution Returns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="distribution-return-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
