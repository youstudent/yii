<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m170414_112848_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id'=>$this->integer(11)->notNull()->defaultValue(0)->comment('订单id'),
            'goods_id'=>$this->integer(11)->notNull()->defaultValue(0)->comment('商品id'),
            'goods_name'=>$this->string(50)->notNull()->comment('商品名称'),
            'logo'=>$this->string(50)->notNull()->comment('商品图片'),
            'price'=>$this->decimal(10,2)->notNull()->defaultValue(0)->comment('商品价格'),
            'amount'=>$this->integer(10)->notNull()->defaultValue(0)->comment('商品数量'),
            'total_price'=>$this->decimal(10,2)->notNull()->defaultValue(0)->comment('小计'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
