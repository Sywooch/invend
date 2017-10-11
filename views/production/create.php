<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Production */

$this->title = Yii::t('app', 'New Production');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Production List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="production-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
