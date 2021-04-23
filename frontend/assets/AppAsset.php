<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'css/animate.css',
        'css/bootstrap.css',
        'css/bootstrap.min.css',
        'css/style.css',
        'css/font-awesome/css/font-awesome.css',
    ];
    public $js = [
        // 'js/jquery-2.1.4.min.js',
        'js/bootstrap.js',        
        'js/inspinia.js',       
        'js/jquery-ui-1.10.4.min.js',
        'js/jquery-ui.custom.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',  
        'js/plugins/flot/jquery.flot.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.spline.js',
        'js/plugins/flot/jquery.flot.resize.js',
        'js/plugins/flot/jquery.flot.pie.js',
        'js/plugins/peity/jquery.peity.min.js',
        'js/demo/peity-demo.js',
       
        'js/plugins/pace/pace.min.js',
        'js/plugins/jquery-ui/jquery-ui.min.js',
        'js/plugins/gritter/jquery.gritter.min.js',
        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/demo/sparkline-demo.js',
        'js/plugins/chartJs/Chart.min.js',
        'js/plugins/toastr/toastr.min.js',
    
    
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
