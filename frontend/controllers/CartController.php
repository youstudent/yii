<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 下午 7:26
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Cart;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;

class CartController extends Controller
{
    public $layout = 'cart.php';   //选择模板
    public $enableCsrfValidation = false;//关闭验证

    public function actionCart()
    {
        //接收表单传过来的  商品id  和商品的数量
        $goods_id = $_POST['id'];
        $num = $_POST['amount'];

        //如果没有登陆就保存到 cookies 中
        if (\Yii::$app->user->isGuest){
            /*//为了避免数据的被覆盖  所有要把 原来cookies中的数据取出来 在一起保存
            //将cookies中的值取出来
            $cookies = \Yii::$app->request->cookies;  //实例化取出cookies组件
            //将cookies中名字是cart的数据取出来
            $cookie = $cookies->get('cart');
            //将去取出来的数据反序列化
            if ($cookie == null) {//如果cookie中没有值 反序列化
                $cart = [];
            } else {
                $cart = unserialize($cookie->value);
            }
            //如果商品存在就直将商品中的   数量加上
            if (array_key_exists($goods_id, $cart)) {
                $cart[$goods_id] += $num;
            } else {
                //如果商品不存在就直接添加
                $cart[$goods_id] = $num;
            }
            //将数据保存到 cookies 中
            //$data = [$goods_id=>$num]; //已数组到方式保存
            $cookies = \Yii::$app->response->cookies; //实例化保存cookies组件
            //创建cookie对象
            $cookie = new Cookie([
                'name' => 'cart',  //名字
                'value' => serialize($cart),  //将数组序列化成字符串
            ]);
            $cookies->add($cookie); //将 cookie 对象 保存到 cookie中*/
            \Yii::$app->cookies->addCook($goods_id,$num)->save();
        } else {
            //登陆就保存到数据库中
            $member_id = \Yii::$app->user->id;
            $goods = Cart::findOne(['goods_id' => $goods_id, 'member_id' => $member_id]);
            // $goods = Cart::find()->where(['goods_id'=>$goods_id])->andWhere(['member_id'=>$member_id])->all();
            if ($goods) {
                $goods->num += $num;  //将查询到商品 的数量加上
                $goods->save(false);
            } else {
                $CartModel = new Cart();
                $CartModel->goods_id = $goods_id;
                $CartModel->member_id = $member_id;
                $CartModel->num = $num;
                $CartModel->save();
            }

        }

        //跳转到购物车页面
        return $this->redirect(['cart/carts']);
    }


    //购物车页面
    public function actionCarts()
    {
        if (\Yii::$app->user->isGuest) {
           /* //将cookies中的值取出来
            $cookies = \Yii::$app->request->cookies;  //实例化取出cookies组件
            //将cookies中名字是cart的数据取出来
            $cookie = $cookies->get('cart');
            //将去取出来的数据反序列化
            if ($cookie == null) {//如果cookie中没有值 反序列化
                $cart = [];
            } else {
                $cart = unserialize($cookie->value);
            }*/
           $cart = \Yii::$app->cookies->_cart;
        } else {
            //从数据库中取出数据
            $cart = Cart::find()->where(['member_id' => \Yii::$app->user->id])->asArray()->all();
            //$cart=['goods_id'=>1]  id=>num
            $cart =ArrayHelper::map($cart,'goods_id','num');
        }
        //定义一个空数组   保存商品信息 和商品数量
        $models = [];
        //循环 取出的数据(数组)
        foreach ($cart as $id=>$num) {
            //根据下标(goods_id) 查询商品数据
                $goods = Goods::find()->where(['id' =>$id])->asArray()->one();
                $goods['num'] = $num;//将商品数量赋值
                $models[] = $goods;
            }

        //var_dump($total);exit;
        //将数据分配到页面
        return $this->render('cart', ['models' => $models]);
    }

    //商品的修改
    public function actionAjax($filter)
    {
        switch ($filter){
            case 'edit':
            $goods_id = \Yii::$app->request->post('goods_id');
            $num = \Yii::$app->request->post('num');
            //如果是游客  就修改 cookies中的值   如果不是游客就修改数据库中的值
            if (\Yii::$app->user->isGuest){
                /*//获取 cookies
                $cookies = \Yii::$app->request->cookies;
                $cart = $cookies->get('cart');
                if ($cart == null){
                    $cart = [];
                }else{
                    $cart = unserialize($cart->value);
                }
                //将新的数据保存到 cookies中
                 $cart[$goods_id] = $num;
                 $cookies= \Yii::$app->response->cookies;
                 $cookie = new Cookie([
                     'name'=>'cart',
                     'value'=>serialize($cart)
                 ]);
                 //保存数据
                $cookies->add($cookie);*/
                \Yii::$app->cookies->edit($goods_id,$num)->save();
                return 'success';

            }else{
                //登陆保存到数据库
                $goods = Cart::findOne(['goods_id'=>$goods_id,'member_id'=>\Yii::$app->user->id]);
                $goods->num =$num;
                $goods->save(false);
            }
            break;
            //删除
            case 'del':
                $goods_id = \Yii::$app->request->post('goods_id');
                //如果是游客就 清除cookies中对应的数据  如果是登陆用户就 删除数据库中对应的数据
              if (\Yii::$app->user->isGuest){
                  /*$cookies = \Yii::$app->request->cookies;
                  $cart = $cookies->get('cart');
                  if ($cart == null){
                      $cart = [];
                  }else{
                      $cart = unserialize($cart->value);
                  }
                  //将新的数据保存到 cookies中
                  unset($cart[$goods_id]);

                  $cookies= \Yii::$app->response->cookies;
                  $cookie = new Cookie([
                      'name'=>'cart',
                      'value'=>serialize($cart)
                  ]);
                  //保存数据
                  $cookies->add($cookie);*/
                 \Yii::$app->cookies->delCook($goods_id)->save();
                  return 'success';
              }else{
                  Cart::deleteAll(['goods_id'=>$goods_id,'member_id'=>\Yii::$app->user->id]);
              }
              break;

        }

    }

}