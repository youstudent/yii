<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m170401_025037_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            'goods_id' => $this->bigInteger()->notNull()->comment('商品ID'),
            'content'=>$this->text()->comment('商品表述'),
        ]);
        $this->addPrimaryKey('goods_id','goods_intro','goods_id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
