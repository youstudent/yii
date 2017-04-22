<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170409_152320_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer(5)->comment('用户ID'),
            'consignee'=>$this->string(50)->notNull()->comment('收货人'),
            'address'=>$this->string(50)->notNull()->comment('收货地址'),
            'detailed_address'=>$this->string(50)->notNull()->comment('详细地址'),
            'tel'=>$this->integer(11)->notNull()->comment('手机号'),
            'default'=>$this->smallInteger(3)->comment('默认地址  0:不是默认  1:默认地址')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
