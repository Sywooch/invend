

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\ProductCategory;
use app\models\Location;
use app\models\Vendor;

$this->title = Yii::t('app', 'Purchase Order List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">
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
                <a href="<?= Url::toRoute(['/po/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i>New Purchase Order</a>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin(); ?>    
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
                                'attribute'=>'product_id', 
                                'filter'=> ArrayHelper::map(Product::find()->orderBy('item_name ASC')->all(), 'id', 'item_name'),
                                'value' => 'product.item_name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'product_category_id', 
                                'filter'=> ArrayHelper::map(ProductCategory::find()->orderBy('name ASC')->all(), 'id', 'name'),
                                'value' => 'productCategory.name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'location_id', 
                                'filter'=> ArrayHelper::map(Location::find()->orderBy('name ASC')->all(), 'id', 'name'),
                                'value' => 'location.name',
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'last_vendor_id', 
                                'filter'=> ArrayHelper::map(Vendor::find()->orderBy('name ASC')->all(), 'id', 'name'),
                                'value' => 'vendor.name',
                                'format'=>'text', 
                            ],
                            'quantity',
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
                            'remarks',
                            
                        ],
                        'pjax'=>true,
                        'showPageSummary'=>true,
                        'responsive' => true,
                        'resizableColumns'=>true,
                        'hover' => true,
                        
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
