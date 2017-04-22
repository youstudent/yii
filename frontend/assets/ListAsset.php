<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 上午 11:50
 */

namespace frontend\assets;


use yii\web\View;
use yii\web\AssetBundle;

class ListAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/goods.css',
        'style/list.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/footer.css'
    ];
    public $js = [
        'js/header.js',
        'js/index.js',
        'js/list.js',
        'js/goods.js',
        'js/jqzoom-core.js'

    ];
    public $depends = [
        //JqueryAsset::className(),
        'yii\web\JqueryAsset',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions=[
        'position'=>View::POS_HEAD,
    ];

}