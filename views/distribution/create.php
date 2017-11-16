<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distribution */

$this->title = Yii::t('app', 'Create Distribution');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribution-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
