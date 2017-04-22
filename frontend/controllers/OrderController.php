<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class OrderController extends \yii\web\Controller
{
    public $layout = 'cart.php';
    //订单页面
    public function actionOrder()
    {
        //如果是游客就 跳转到登陆页面
        if (\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }
        //查询收货地址
        $address = Address::find()->orderBy(['id'=>SORT_DESC])->all();
        $cart = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->asArray()->all();
        //构造数据格式
        $cart = ArrayHelper::map($cart,'goods_id','num');
         $models = [];
         $total = 0;
         $mun = 0;
        // $sn = 0;
        foreach ($cart as $id=>$num){
            $cart  = Goods::find()->where(['id'=>$id])->asArray()->one();
            $cart['num']=$num;
            $models[] =$cart;
            $total+=$cart['num']*$cart['shop_price'];
            $mun++;
           // $sn += $mun;
        }
         $order = new Order();
        if (\Yii::$app->request->isPost){
            //收货地址 id
            $address_id= \Yii::$app->request->post('address_id');
            // 根据  地址id 和用户id 查询  对应地址信息
            $address = Address::findOne(['id'=>$address_id,'member_id'=>\Yii::$app->user->id]);
           if ($address == null){
                throw new HttpException('404','地址不存在');
            }
            $delivery = \Yii::$app->request->post('delivery');
            $pay = \Yii::$app->request->post('pay');
            $order->member_id = \Yii::$app->user->id;  //订单用户id
            $order->province_name=$address->province;  //省
            $order->city_name=$address->city;  //市
            $order->area_name=$address->area;  //县
            $order->detail_address=$address->detailed_address; //详细地址
            $order->tel=$address->tel; //电话号码
            $order->name =$address->consignee;  //收货姓名
            $order->delivery_name=Order::$deliveres[$delivery][0];  //配送方式的名字
            $order->delivery_id= $delivery;    //配送方式的id
            $order->delivery_price =Order::$deliveres[$delivery][1];  //运费
            $order->pay_type_name =Order::$pays[$pay][0];  //支付名字
            $order->pay_type_id = $pay;   //支付id
            $order->price = 0;//价格
            $order->status = 1;
            $order->trade_no =date('Y-m-d-').rand(1111,9999);//交易号
            $order->create_time =time();  //下单时间
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();//开启事务
            try{
               $order->save(false); //保存数据
                $carts = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
               foreach($carts as $cart){
                   $goods = Goods::findOne(['id'=>$cart->goods_id]);
                   $detail = new OrderDetail();
                   $detail->order_info_id=$order->id;
                   $detail->goods_name =$goods->name;
                   $detail->logo =$goods->logo;
                   $detail->goods_id =$goods->id;
                   $detail->price = $goods->shop_price;  //单价
                   $detail->amount = $cart->num;
                   if ($cart->num > $goods->sort){
                       throw new Exception('商品数量不足');
                   }
                   $detail->total_price = $goods->shop_price * $cart->num-($order->delivery_price);
                   $detail->save(false);
                   //减库存
                   $goods->stock -= $cart->num;
                   $goods->save();
                   //清空购物车
                   $cart->delete();
               }
               $transaction->commit(); //提交事物
            }catch (Exception $e){
               //如果 捕获到了异常 就回滚事物
              $transaction->rollBack();

             return $this->redirect(['order/order']);
            }
            //跳转到下单成功页面
              return $this->redirect(['order/success']);
        }
        return $this->render('order',['address'=>$address,'models'=>$models,'total'=>$total,'mun'=>$mun]);
    }


    //下单成功
    public function actionSuccess(){
       // $name = $_POST['address_id'];
       //var_dump($name);exit;
        return $this->render('success');


    }

}
