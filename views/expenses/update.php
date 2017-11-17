<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Expenses */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Expenses',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Expenses List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="expenses-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
