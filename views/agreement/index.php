<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Agreements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agreement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Agreement'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tenant_name',
            'owner_name',
            'frequency',
            'rent_amount',
            'rent_start_date',
            'goodwill',
            'goodwill_duration',
            'goodwill_start_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
