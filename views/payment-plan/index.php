<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Agreement;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payment Plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'filter'=> ArrayHelper::map(Agreement::find()->orderBy('tenant_name ASC')->all(), 'id', 'fullName'),
                'value' => 'agreement.fullName',
                'format'=>'text', 
                'width'=>'100px', 
                'pageSummary'=>'Total'
            ],
            [
                'attribute'=>'frequency', 
                'format'=>'text', 
                'width'=>'100px', 
            ],
            [
                'attribute'=>'currency', 
                'format'=>'text', 
                'width'=>'100px', 
            ],
            [
                'label'=>'Amount Due', 
                'attribute'=>'amount_due', 
                'format'=>['decimal', 2], 
                'hAlign'=>'right', 
                'width'=>'100px', 
                'pageSummary'=>true
            ],
            [
                'label'=>'Amount Paid', 
                'attribute'=>'amount_paid', 
                'format'=>['decimal', 2], 
                'hAlign'=>'right', 
                'width'=>'100px', 
                'pageSummary'=>true
            ],
            [
                'class'=>'kartik\grid\FormulaColumn', 
                'label'=>'Amount In Arrears', 
                'format' => ['decimal', 2],
                'value'=>function ($model, $key, $index, $widget) { 
                    $p = compact('model', 'key', 'index');
                    return $widget->col(3, $p) - $widget->col(4, $p) ;
                }, 
                'hAlign'=>'right', 
                'width'=>'120px', 
                'pageSummary'=>true
            ],
            [
                'attribute'=>'notes', 
                'format'=>'text', 
                'width'=>'120px'
            ],
            [
                'label'=>'Date', 
                'attribute'=>'time', 
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
        ],
        'pjax'=>true,
        'showPageSummary'=>true,
        'responsive' => true,
        'resizableColumns'=>true,
        'hover' => true,
        'panel'=>[
            'type'=>'primary',
            'heading'=>'Payments Plan'
        ],
        
    ]); ?>

</div>
