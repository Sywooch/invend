<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Sales Order List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-order-index">
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
                <a href="<?= Url::toRoute(['/sales-order/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i> Sales Order</a>
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
                                'attribute'=>'number', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'location_id', 
                                'value' => 'location.name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'customer_id', 
                                'value' => 'customer.name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'sales_rep_id', 
                                'value' => 'user.username',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'status', 
                                'value'=>function ($model, $key, $index, $widget) {
                                    return $model->status == 8 ? "<span class='label label-primary'>Fulfilled, Invoiced</span>" : "<span class='label label-primary'>Fulfilled, Uninvoiced</span>";
                                },
                                'vAlign'=>'middle',
                                'format'=>'raw',
                            ],
                            [
                                'attribute'=>'date', 
                                'format'=>['date', 'php:d-M-Y'], 
                                'xlFormat'=>'mmm\-dd\, yyyy',  // different date format
                            ],
                            [
                                'attribute'=>'due_date', 
                                'format'=>['date', 'php:d-M-Y'], 
                                'xlFormat'=>'mmm\-dd\, yyyy',  // different date format
                            ],
                            [
                                'attribute'=>'remarks', 
                                'format'=>'text', 
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
