<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Donation List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-index">
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
                <a href="<?= Url::toRoute(['/donation/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i>New Donation</a>
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
                                'attribute'=>'quantity', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'price', 
                                'format'=>'text', 
                            ],
                            [
                                'class'=>'kartik\grid\FormulaColumn', 
                                'label'=>'Total', 
                                'format' => ['decimal', 2],
                                'value'=>function ($model, $key, $index, $widget) { 
                                    $p = compact('model', 'key', 'index');
                                    return $widget->col(0, $p) * $widget->col(1, $p) ;
                                }, 
                                'hAlign'=>'left', 
                                'width'=>'120px', 
                                'pageSummary'=>true
                            ],
                            [
                                'attribute'=>'reason', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'date', 
                                'format'=>['date', 'php:d-M-Y'], 
                                'xlFormat'=>'mmm\-dd\, yyyy',  // different date format
                            ],
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

