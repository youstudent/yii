<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/13 0013
 * Time: 下午 12:24
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/cart.css',
        'style/login.css',
        'style/fillin.css',
        'style/footer.css',
        'style/success.css'
    ];
    public $js = [
        'js/cart1.js',
        'js/cart2.js'
    ];
    public $depends = [
        //JqueryAsset::className(),
        'yii\web\JqueryAsset',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}