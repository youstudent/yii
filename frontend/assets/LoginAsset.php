<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9 0009
 * Time: 上午 11:25
 */

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/cart.css',
        'style/login.css',
        'style/footer.css',
    ];
    public $js = [
        'js/cart1.js'
    ];
    public $depends = [
        //JqueryAsset::className(),
        'yii\web\JqueryAsset',
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}