<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170329_063904_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(10)->comment('状态'),
            'sort'=>$this->integer(10)->comment('排序'),
            'is_help'=>$this->integer(10)->comment('帮助是否'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
