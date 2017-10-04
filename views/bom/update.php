<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bom */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Boms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelBom->name, 'url' => ['view', 'id' => $modelBom->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="bom-update">

    <?= $this->render('_form', [
        'modelBom' => $modelBom,
        'modelsStage'  => $modelsStage,
        'modelsOutput'  => $modelsOutput,
        'modelsComponents' => $modelsComponents,
        'total_component' => $total_component,
    ]) ?>

</div>
