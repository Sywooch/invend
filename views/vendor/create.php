<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vendor */

$this->title = Yii::t('app', 'Vendor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vendor List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-create">

    <?= $this->render('_form', [
        'modelVendor' => $modelVendor,
    ]) ?>

</div>
