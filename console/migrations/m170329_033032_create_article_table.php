<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170329_033032_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章名称'),
            'article_category_id'=>$this->integer(10)->comment('文章内容id'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(20)->defaultValue(0)->comment('状态'),
            'sort'=>$this->integer(20)->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer()->comment('录入时间'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
