<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170406_030713_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('一级菜单'),
            'parent_id'=>$this->string()->comment('上级分类ID'),
            'description'=>$this->text()->comment('简介'),
            'url'=>$this->string()->comment('路由')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
