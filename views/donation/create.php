<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Donation */

$this->title = Yii::t('app', 'New Donation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donation List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
