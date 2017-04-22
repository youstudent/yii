<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170401_140610_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->comment('用户名'),
            'password'=>$this->string(50)->notNull()->comment('密码'),
            'salt'=>$this->string(10)->notNull()->comment('盐'),
            'email'=>$this->string(30)->notNull()->comment('邮箱'),
            'token'=>$this->string(32)->notNull()->comment('自动登陆令牌'),
            'token_carete_time'=>$this->string(30)->comment('令牌创建时间'),
            'add_time'=>$this->integer(11)->notNull()->defaultValue(0)->comment('注册时间'),
            'last_login_time'=>$this->integer()->notNull()->defaultValue(0)->comment('最后登陆时间'),
            'last_login_ip'=>$this->string(15)->comment('登陆ip'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
