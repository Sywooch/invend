<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;
use app\model\productCategory;
use app\model\productType;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'Trial Balance');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-index">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Advance Search </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content m-b-sm border-bottom">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title text-right">
                <a href="<?= Url::toRoute(['/sales-order/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i>New Sales</a>
                <a href="<?= Url::toRoute(['/po/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i>New Purchase</a>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [

                            [
                                'attribute'=>'account', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'type', 
                                'format'=>'text', 
                            ],
                            [
                                'label'=>'credit', 
                                'attribute'=>'credit', 
                                'format'=>['decimal', 2], 
                                'hAlign'=>'right', 
                                'width'=>'100px', 
                                'pageSummary'=>true
                            ],
                            [
                                'label'=>'debit', 
                                'attribute'=>'debit', 
                                'format'=>['decimal', 2], 
                                'hAlign'=>'right', 
                                'width'=>'100px', 
                                'pageSummary'=>true
                            ],
                            [
                                'class'=>'kartik\grid\FormulaColumn', 
                                'label'=>'Total', 
                                'format' => ['decimal', 2],
                                'value'=>function ($model, $key, $index, $widget) { 
                                    $p = compact('model', 'key', 'index');
                                    return $widget->col(2, $p) - $widget->col(3, $p) ;
                                }, 
                                'hAlign'=>'right', 
                                'width'=>'120px', 
                                'pageSummary'=>true
                            ],
                            [
                                'label'=>'Date', 
                                'attribute'=>'time', 
                                'format'=>['date', 'php:d-M-Y'], 
                                'xlFormat'=>'mmm\-dd\, yyyy',  // different date format
                                'width'=>'100px'
                            ],
                            [
                                'attribute'=>'remarks', 
                                'format'=>'text', 
                            ],
                        ],
                        'pjax'=>true,
                        'showPageSummary'=>true,
                        'responsive' => true,
                        'resizableColumns'=>true,
                        'hover' => true,
                        'panel'=>[
                            'type'=>'default',
                            'heading'=>'Payments Plan'
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
