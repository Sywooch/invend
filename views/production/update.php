<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Production */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Production List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="production-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
