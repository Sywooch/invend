<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView; 
use kartik\grid\ActionColumn;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Vendor List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-index">
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
                <a href="<?= Url::toRoute(['/vendor/create']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-pencil"></i>New Vendor</a>
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
                                'attribute'=>'name', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'contact', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'phone', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'email', 
                                'format'=>'text', 
                            ],
                            [
                                'attribute'=>'website', 
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

