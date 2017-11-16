<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Donation */

$this->title = Yii::t('app', 'Create Donation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
