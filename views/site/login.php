<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">
            <h2 class="font-bold">Welcome to INVEND SYSTEM</h2>

            <p>
                Perfectly designed and precisely prepared ...
            </p>

            <p>
                Developed Specifically for Sachet Water Industry.
            </p>

            <p>
                It has realtime dashboards, Purchases and Sales.
            </p>

        </div>
        <div class="col-md-6">
            <div class="ibox-content">

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => [
                        'class' => 'm-t'
                     ]
                ]); ?>
                    <div class="form-group">
                        <?= $form->field($model, 'username')->textInput(['required' => true,'placeholder' => 'username','autofocus' => true])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'password')->passwordInput(['required' => true,'placeholder' => 'password'])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

                <a href="#">
                    <small>Forgot password?</small>
                </a>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright SmartFanis Company Limited
        </div>
        <div class="col-md-6 text-right">
           <small>© 2017-2020</small>
        </div>
    </div>
</div>








