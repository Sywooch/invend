<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Wastage */

$this->title = Yii::t('app', 'Create Wastage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wastages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wastage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
