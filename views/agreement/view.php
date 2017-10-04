<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Agreement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agreements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agreement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'tenant_name',
            'owner_name',
            [
                'label' => 'Property',
                'value' => $model->property->name
            ],
            'frequency',
            [
                'label' => 'Rent Amount',
                'value' => $model->currency . $model->rent_amount
            ],
            [
                'label' => 'Rent Start Date',
                'value' => date('d-m-Y', strtotime($model->rent_start_date))
            ],
            [
                'label' => 'Goodwill Amount',
                'value' => $model->currency . $model->goodwill
            ],
            'goodwill_duration',
            [
                'label' => 'Goodwill Start Date',
                'value' => date('d-m-Y', strtotime($model->goodwill_start_date))
            ],
            'notes',
        ],
    ]) ?>

</div>
