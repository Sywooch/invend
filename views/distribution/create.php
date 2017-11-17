<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distribution */

$this->title = Yii::t('app', 'New Distribution');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distribution List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribution-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
