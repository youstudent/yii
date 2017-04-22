<?php

namespace frontend\models;

use backend\models\Goods;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province_name
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property integer $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property string $pay_type_name
 * @property integer $pay_type_id
 * @property string $price
 * @property integer $status
 * @property string $trade_no
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'tel', 'delivery_id', 'pay_type_id', 'status'], 'integer'],
            [['name', 'tel', 'delivery_name', 'pay_type_name', 'trade_no'], 'self'],
            [['delivery_price', 'price'], 'number'],
            [['name', 'delivery_name', 'create_time'], 'string', 'max' => 50],
            [['province_name', 'city_name', 'area_name'], 'string', 'max' => 10],
            [['detail_address'], 'string', 'max' => 40],
            [['pay_type_name', 'trade_no'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'name' => '收货人',
            'province_name' => '省份',
            'city_name' => '市',
            'area_name' => '县',
            'detail_address' => '详细地址',
            'tel' => '电话号码',
            'delivery_id' => '配送id',
            'delivery_name' => '配送姓名',
            'delivery_price' => '运费',
            'pay_type_name' => '支付名字',
            'pay_type_id' => '支付方式',
            'price' => '商品金额',
            'status' => '订单状态',
            'trade_no' => '交易号',
            'create_time' => '下单时间',
        ];
    }

    //配送方式
    public static $deliveres=[
          1=>['顺丰快递','20','每张订单不满499.00元,运费20.00元'],
          2=>['申通快递','15','每张订单不满499.00元,运费15.00元'],
          3=>['京东快递','10','每张订单不满499.00元,运费10.00元'],
        ];


    //支付方式
    public static  $pays=[
          1=>['货到付款','送货上门后再收款，支持现金、POS机刷卡、支票支付'],
          2=>['支付宝','快'],
          3=>['微信','快'],
        ];

    //与商品表建立多对多关系
    public function getGoods(){

        return $this->hasMany(Goods::className(),['goods_id'=>'id']);
    }
}
