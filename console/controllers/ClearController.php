<?php

namespace yii\console\controllers;

use backend\models\Goods;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\helpers\ArrayHelper;

class ClearController extends \yii\console\Controller
{
        //清理订单超时的方法
    public function actionClear(){
        // 修改 服务器运行脚本的最大时间( 默认 30秒)
        set_time_limit(0);  //将值改为 0 就不会限制时间  一直执行
        while (true){ //死循环 , 循环执行清理
            //1.>>找到订单是未付款的 并且超过支付时间(一小时  3600)的订单    select(查询制定的字段值)
        $order  =  Order::find()->select('id')->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->asArray()->all();
            //2.>>将订单 格式化  修改订单状态值
        $ids = ArrayHelper::map($order,'id','id');
            //修改所有订单状态为1 并且下单时间超过一个小时  状态改为0(取消订单)
        Order::updateAll(['status'=>0],'status=>1 and create_time <'.time()-3600);
            //3.>>根据 order  循环查询订单详情表对应的数据  反库存
        foreach($ids as $id){
            //查询到所有的 订单详情
        $details = OrderDetail::find()->where(['order_info_id'=>$id])->all();
            //返回商品 对应的库存
        foreach($details as $detail){
            //将商品 stock字段数量 加上订单详情表里面的数据   商品id 为订单详情表的goods_id
        Goods::updateAllCounters(['stock'=>$detail->amount,],'id='.$detail->goods_id);

              }

         }

         sleep(1);  //循环间隔时间  , 每秒执行一次
        }
    }

}