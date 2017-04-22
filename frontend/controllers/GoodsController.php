<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 下午 4:22
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use yii\web\Controller;

class GoodsController extends Controller
{
    //制定模板文件
    public $layout = 'list.php';
    public function actionGoods($id){
        //根据id 查询 商品
        $goods =Goods::findOne(['id'=>$id]);
        //根据 goods_id 查询相册
        $gallery = GoodsGallery::find()->where(['goods_id'=>$id])->all();
        $content = GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('goods',['goods'=>$goods,'gallery'=>$gallery,'content'=>$content]);
    }

}