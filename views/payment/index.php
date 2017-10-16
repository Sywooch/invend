<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Payment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        'columns'=>[
            [
                'attribute'=>'agreement_id', 
                'value' => 'agreement.tenant_name',
                'format'=>'text', 
                'width'=>'100px', 
                'pageSummary'=>'Total'
            ],
            [
                'attribute'=>'property', 
                'value' => 'agreement.property.name',
                'format'=>'text', 
                'width'=>'100px', 
            ],
            [
                'attribute'=>'receipt_number', 
                'format'=>'text', 
                'width'=>'100px', 
            ],
            [
                'attribute'=>'type', 
                'format'=>'text', 
                'width'=>'120px'
            ],
            [
                'attribute'=>'mode', 
                'format'=>'text', 
                'width'=>'120px'
            ],
            [
                'attribute'=>'date', 
                'format'=>['date', 'php:d-M-Y'], 
                'xlFormat'=>'mmm\-dd\, yyyy',  // different date format
                'width'=>'100px'
            ],
            [
                'attribute'=>'time', 
                'format'=>['time', 'php:g:i a'], 
                'hAlign'=>'center', 
                'xlFormat'=>'Long Time', // long time
                'width'=>'100px',
            ],
            [
                'label'=>'Amount', 
                'attribute'=>'amount_paid', 
                'format'=>['decimal', 2], 
                'hAlign'=>'right', 
                'width'=>'100px', 
                'pageSummary'=>true
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) {
                    if ($action == 'update' ) {
                        return Url::toRoute(['payment/update', 'id' => $key]);
                    }
                    if ($action == 'view' ) {
                        return Url::toRoute(['payment/view', 'id' => $key]);
                    }
                    if ($action == 'delete' ) {
                        return Url::toRoute(['payment/delete', 'id' => $key]);
                    }
                },
                'viewOptions'=>['title'=>'View', 'data-toggle'=>'tooltip'],
                'updateOptions'=>['title'=>'Edit', 'data-toggle'=>'tooltip'],
                'deleteOptions'=>['title'=>'Delete', 'data-toggle'=>'tooltip'], 
            ],
        ],
        'pjax'=>true,
        'showPageSummary'=>true,
        'responsive' => true,
        'resizableColumns'=>true,
        'panel'=>[
            'type'=>'primary',
            'heading'=>'Payments'
        ],
        
    ]); ?>

</div>
