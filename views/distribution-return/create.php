<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DistributionReturn */

$this->title = Yii::t('app', 'New Distribution Return');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distribution Return List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribution-return-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
