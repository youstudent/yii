<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articlecategory`.
 */
class m170329_073438_create_articlecategory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('articlecategory', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'intro'=>$this->text()->comment('简介'),
            'status'=>$this->integer(10)->comment('状态'),
            'sort'=>$this->integer(10)->comment('排序'),
            'is_help'=>$this->integer(10)->comment('帮助'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('articlecategory');
    }
}
