<?php
namespace frontend\components;

use yii\web\Cookie;

class Cookies extends \yii\base\Component
{
    public $_cart = [];
    //实例化 对象 自动获取  cookies中的数据
     public function __construct(array $config = [])
     {
         $cookies = \Yii::$app->request->cookies;
         $cart = $cookies->get('cart');
         if ($cart == null){
             $cart = [];
         }else{
             $cart = unserialize($cart->value);
         }
         $this->_cart =$cart;
         //return $cart;
        parent::__construct($config);
     }

     //添加
     public function addCook($goods_id,$num=1){
         if(array_key_exists($goods_id,$this->_cart)){
             $this->_cart[$goods_id] += $num;
         }else{
             $this->_cart[$goods_id] = $num;
         }
         return $this;


     }
     //修改
     public function edit($goods_id,$num =1){
         $this->_cart[$goods_id] = $num;
         return $this;

     }

     //删除
     public function delCook($goods_id){
         unset($this->_cart[$goods_id]);
         return $this;

     }

     //保存
     public function save(){
         $cookies= \Yii::$app->response->cookies;
         $cookie = new Cookie([
             'name'=>'cart',
             'value'=>serialize($this->_cart)
         ]);
         //保存数据
         $cookies->add($cookie);


     }
}