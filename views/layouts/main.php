<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;
use app\assets\AppAsset;

AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@app/assets');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>

            <div id="wrapper">

                <?= $this->render('sidebar', ['directoryAsset' => $directoryAsset]) ?>

                <div id="page-wrapper" class="gray-bg">
                    <div class="row border-bottom">
                        <?= $this->render('header', ['directoryAsset' => $directoryAsset]) ?>
                    </div>
                    
                    <div class="row wrapper border-bottom white-bg page-heading">
                        <div class="col-lg-10">
                            <br>
                            <?= Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]) ?>
                            
                        </div>
                        <div class="col-lg-2">

                        </div>
                    </div>
                    <?= Alert::widget() ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="wrapper wrapper-content">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                    <?= $this->render('footer', ['directoryAsset' => $directoryAsset]) ?>
                </div>
            </div>
        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>

