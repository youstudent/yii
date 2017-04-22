<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 上午 11:52
 */

namespace frontend\controllers;


use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use yii\web\Controller;

class ListController extends Controller
{
    //制定模板文件
    public $layout = 'list.php';
    //商品
    public function actionList($id,$name){
        $goods = Goods::find()->where(['goods_category_id'=>$id])->all();
        $brand = Brand::find()->all();
       // $name  = GoodsCategory::findOne(['id'=>$id]);
        return $this->render('list',['goods'=>$goods,'brand'=>$brand,'name'=>$name]);
    }
}