<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = Yii::t('app', 'Payment Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelDocument' => $modelDocument,
        'total_rent_paid' => $total_rent_paid,
        'total_rent_arrears' => $total_rent_arrears,
        'total_goodwill_paid' => $total_goodwill_paid,
        'total_goodwill_arrears' => $total_goodwill_arrears
    ]) ?>

</div>
