<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DistributionReturn */

$this->title = Yii::t('app', 'Create Distribution Return');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distribution Returns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribution-return-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
