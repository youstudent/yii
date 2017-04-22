<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170413_045016_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer(11)->notNull()->comment('商品id'),
            'num'=>$this->integer(11)->notNull()->comment('商品数量'),
            'member_id'=>$this->integer(2)->notNull()->comment('用户id'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
