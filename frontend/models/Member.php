<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $tel
 * @property string $email
 * @property integer $add_time
 * @property integer $last_login_time
 * @property string $last_login_ip
 * @property string $salt
 * @property integer $status
 * @property string $token
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $passwords;//确定密码
    public $code;//验证码
    public $checkbox;//协议
    public $duanxin;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tel','username', 'password', 'email','checkbox','duanxin'], 'required'],
            [['tel', 'add_time', 'last_login_time', 'status','duanxin'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password', 'token','passwords'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 30],
            [['last_login_ip', 'salt'], 'string', 'max' => 20],
            [['code'],'captcha'],
            [['username','tel','email'],'unique'],
            [['email'],'email'],
            [['passwords'],'compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            [['tel'],'match','pattern'=>'/^[1][3578][0-9]{9}$/','message'=>'号码格式不对'],
            [['duanxin'],'validateduanxin'],
        ];
    }
    public function validateduanxin()
    {
        if ($this->duanxin != Yii::$app->session->get('tel'.$this->tel)){
            $this->addError('duanxin','验证码不正确');
        }

    }

       //短信
    public static function code($tel,$code){

        // 配置信息
        $config = [
            'app_key'    => '23741750',
            'app_secret' => 'f2f4a1391de18d0f40ec7c4f207be42a',
        ];

        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($tel)
            ->setSmsParam([
                'content' => $code
            ])
            ->setSmsFreeSignName('刘老师')
            ->setSmsTemplateCode('SMS_60745074');

        $resp = $client->execute($req);

        //return $code;
        //var_dump($code);

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名：',
            'password' => '密码：',
            'tel' => '手机号码：',
            'email' => '邮箱：',
            'add_time' => '注册时间',
            'last_login_time' => '最后登陆时间',
            'last_login_ip' => '最后登陆ip',
            'salt' => '盐',
            'status' => '状态:-1删除 0禁用 1正常 ',
            'token' => '令牌字符串',
            'passwords'=>'确认密码：',
            'code'=>'验证码：',
            'duanxin'=>'短信验证：',
            'checkbox'=>'协议'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
        //return $this->auth_key == $authKey;
    }
}
