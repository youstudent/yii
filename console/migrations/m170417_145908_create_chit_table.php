<?php

use yii\db\Migration;

/**
 * Handles the creation of table `chit`.
 */
class m170417_145908_create_chit_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chit', [
            'id' => $this->primaryKey(),
            'tel'=>$this->integer(11)->comment('电话号码'),
            'times'=>$this->integer(11)->comment('发送次数'),
            'date'=>$this->string(50)->comment('日期')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('chit');
    }
}
