<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/animate.css',
        'css/plugins/toastr/toastr.min.css',
        'js/plugins/gritter/jquery.gritter.css',
        'font-awesome/css/font-awesome.css',  

    ];
    public $js = [
        'js/app.js',
        'js/inspinia.js',

        'js/plugins/pace/pace.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',

        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        
        'js/plugins/flot/jquery.flot.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.resize.js',
        'js/plugins/flot/jquery.flot.spline.js',
        'js/plugins/flot/jquery.flot.pie.js',

        'js/plugins/chartJs/Chart.min.js',

        'js/plugins/peity/jquery.peity.min.js',
        'js/demo/peity-demo.js',

        'js/plugins/gritter/jquery.gritter.min.js',

        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/demo/sparkline-demo.js',

        'js/plugins/toastr/toastr.min.js'

    ];
    public $depends = [
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
