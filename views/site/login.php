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
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
            </p>

            <p>
                When an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <p>
                <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
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

                <p class="text-muted text-center">
                    <small>Do not have an account?</small>
                </p>

                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>

                <p class="m-t">
                    <small>Inspinia we app framework base on Bootstrap 3 &copy; 2017</small>
                </p>
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








