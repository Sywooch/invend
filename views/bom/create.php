<?php

use yii\web\View;

/* @var $this View */
/* @var $titles DataTitles */
/* @var $model app\models\fs\Account */


?>
<div class="bom-create">

    <?= $this->render('_form', [
        'modelBom' => $modelBom,
        'modelsStage'  => $modelsStage,
        'modelsOutput'  => $modelsOutput,
        'modelsComponents' => $modelsComponents,
        'total_component' => $total_component,
    ]) ?>

</div>