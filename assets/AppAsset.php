<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/dropkick/production/css/dropkick.css',
        'js/jquery-ui-custom/jquery-ui.css',
        'js/jquery-ui-custom/jquery-ui.theme.css',
        'css/font-awesome/css/font-awesome.min.css',
        'css/site.css',
        'css/dialog.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/isotope.pkgd.min.2.2.0.js',
        'js/dropkick/production/dropkick.min.js',
        'js/dropkick/plugins/dropkick.jquery.js',
        'js/jquery-ui-custom/jquery-ui.min.js',
        'js/jquery.actual.min.js',
        'js/jquery.blockui.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
