<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expenses */

$this->title = Yii::t('app', 'New Expenses');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Expenses List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
