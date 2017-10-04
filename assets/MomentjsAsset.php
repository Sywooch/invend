<?php
namespace jcabanillas\inspinia;

/**
 * Class FontawesomeAsset
 *
 * @package jcabanillas\inspinia
 */
class MomentjsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/momentjs';
    public $js = [
        'min/moment.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->js[] = 'locale/'.strtolower(\Yii::$app->language).'.js';
    }
}