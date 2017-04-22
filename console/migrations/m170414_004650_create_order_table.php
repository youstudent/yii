<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170414_004650_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer(11)->notNull()->defaultValue(0)->comment('会员ID'),
            'name'=>$this->string(50)->notNull()->comment('收货人'),
            'province_name'=>$this->string(10)->notNull()->defaultValue(0)->comment('省份'),
            'city_name'=>$this->string(10)->notNull()->defaultValue(0)->comment('市'),
            'area_name'=>$this->string(10)->notNull()->defaultValue(0)->comment('县'),
            'detail_address'=>$this->string(40)->notNull()->defaultValue(0)->comment('详细地址'),
            'tel'=>$this->integer(11)->notNull()->comment('电话号码'),
            'delivery_id'=>$this->integer(11)->notNull()->defaultValue(0)->comment('配送id'),
            'delivery_name'=>$this->string(50)->notNull()->comment('配送姓名'),
            'delivery_price'=>$this->decimal(9,2)->notNull()->defaultValue(0)->comment('运费'),
            'pay_type_name'=>$this->string(30)->notNull()->comment('支付名字'),
            'pay_type_id'=>$this->integer(11)->notNull()->defaultValue(0)->comment('支付方式'),
            'price'=>$this->decimal(10,2)->notNull()->defaultValue(0)->comment('商品金额'),
            'status'=>$this->integer(11)->notNull()->defaultValue(0)->comment('订单状态'),
            'trade_no'=>$this->string(30)->notNull()->comment('交易号'),
            'create_time'=>$this->string(50)->notNull()->defaultValue(0)->comment('下单时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
