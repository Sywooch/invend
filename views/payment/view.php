<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

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
            'receipt_number',
            'type',
            [
                'label' => 'Amount Paid',
                'value' => $model->currency . $model->amount_paid
            ],
            'mode',
            'bank_name',
            'cheque_number',
            'payee_name',
            'payee_mobile_number',
            'payee_email:email',
            'payee_address',
            'date',
        ],
    ]) ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
               ['class' => 'yii\grid\SerialColumn'],
               'notes',
               'time',
                [
                    'attribute' => 'Image',
                    'format' => 'raw',
                    'value' => function ($modelDocument) {   
                        if ($modelDocument->image_web_filename!='')
                          return '<img src="'.Yii::$app->homeUrl. '/uploads/payment/'.$modelDocument->image_web_filename.'" width="50px" height="auto">'; else return 'no image';
                    },
                ],
           ],
       ]); ?>

</div>
