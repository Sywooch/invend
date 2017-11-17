<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wastage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wastage',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wastage List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wastage-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
