<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170328_133114_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('商品名'),
            'intro'=>$this->text()->comment('简介'),
            'logo'=>$this->string()->notNull()->comment('LOGO'),
            'status'=>$this->integer()->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer()->defaultValue(1)->comment('排序'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
