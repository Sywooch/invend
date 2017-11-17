<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Wastage */

$this->title = Yii::t('app', 'New Wastage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wastage List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wastage-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
