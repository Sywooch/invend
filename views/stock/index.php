<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\ProductCategory;
use app\models\Location;
use app\models\Vendor;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Stock'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
            'panel'=>[
                'type'=>'primary',
                'heading'=>'Payments Plan'
            ],
            
        ]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute'=>'product_id', 
                    'value' => 'product.item_name',
                    'format'=>'text', 
                ],
                [
                    'attribute'=>'product_category_id', 
                    'value' => 'productCategory.name',
                    'format'=>'text', 
                ],
                [
                    'attribute'=>'location_id', 
                    'value' => 'location.name',
                    'format'=>'text', 
                ],
                [
                    'attribute'=>'last_vendor_id', 
                    'value' => 'vendor.name',
                    'format'=>'text', 
                ],
                'quantity',
                'time',
                'remarks',
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
