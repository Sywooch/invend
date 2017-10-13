<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;
use app\model\productCategory;
use app\model\productType;

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
                                'attribute'=>'item_name', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'item_code', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'product_category_id', 
                                'filter'=> ArrayHelper::map(productCategory::find()->where(['active' => 1])->orderBy('name ASC')->all(), 'id', 'name'), 
                                'value' => 'productCategory.name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'product_type_id', 
                                'filter'=> ArrayHelper::map(productType::find()->where(['active' => 1])->orderBy('name ASC')->all(), 'id', 'name'), 
                                'value' => 'productType.name',
                                'format'=>'text', 
                            ],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
