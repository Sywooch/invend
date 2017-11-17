<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Distribution */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Distribution',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distribution list'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="distribution-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
