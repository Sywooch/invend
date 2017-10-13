<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;
use app\model\location;
use app\model\Customer;

$this->title = Yii::t('app', 'Sales List');
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
                <a href="<?= Url::toRoute(['/sales-order/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i>New Sales</a>
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
                        'showOnEmpty'=>true,
                        'columns' => [
                            [
                                'attribute'=>'number', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'location_id', 
                                'filter'=> ArrayHelper::map(Location::find()->where(['active' => 1])->orderBy('name ASC')->all(), 'id', 'name'), 
                                'value' => 'location.name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'customer_id', 
                                'filter'=> ArrayHelper::map(Customer::find()->where(['active' => 1])->orderBy('name ASC')->all(), 'id', 'name'), 
                                'value' => 'customer.name',
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
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
