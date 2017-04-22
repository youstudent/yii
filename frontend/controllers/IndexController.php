<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 上午 9:23
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Index;
use yii\web\Controller;

class IndexController extends Controller
{
    public $layout =  'index.php';

    //列表页面
    public function actionIndex(){
        $goods = Goods::find()->all();
        $hosts = Goods::find()->where(['in_on_sale'=>1])->all();
        $on_hosts=Goods::find()->where(['in_on_sale'=>0])->all();
        $xinpin = Index::xinpin();
        return $this->render('index',['goods'=>$goods,'hosts'=>$hosts,'on_hosts'=>$on_hosts,'xinpin'=>$xinpin]);

    }
    public function actionList(){

        return $this->render('list');
    }


}