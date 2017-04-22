<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10 0010
 * Time: 上午 10:37
 */

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class Address extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css',
        'style/login.css',
        'style/footer.css',
    ];

    public $js = [
        'js/header.js',
        'js/home.js',
        'js/jsAddress.js'

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