<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170408_143037_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->comment('用户名'),
            'password'=>$this->string(32)->notNull()->comment('密码'),
            'tel'=>$this->integer(11)->comment('电话号码'),
            'email'=>$this->string(30)->notNull()->comment('邮箱'),
            'add_time'=>$this->integer(11)->notNull()->comment('注册时间'),
            'last_login_time'=>$this->integer()->notNull()->comment('最后登陆时间'),
            'last_login_ip'=>$this->string(20)->notNull()->comment('最后登陆ip'),
            'salt'=>$this->string(20)->notNull()->comment('盐'),
            'status'=>$this->smallInteger(4)->notNull()->comment('状态:-1删除 0禁用 1正常 '),
            'token'=>$this->string(32)->notNull()->comment('令牌字符串'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
