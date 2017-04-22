<?php

namespace backend\models;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $token
 * @property string $token_carete_time
 * @property integer $add_time
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
     public $img_file; //保存图片
     public $code;//验证码
     public $search;
     public $role=[];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password','email'], 'required'],
            [['add_time', 'last_login_time'], 'integer'],
            [['username', 'password'], 'string'],
            [['salt','username'], 'string', 'max' => 10],
            [['email', 'token_carete_time'], 'string', 'max' => 30],
            [['token'], 'string', 'max' => 32],
            [['last_login_ip'], 'string', 'max' => 15],
            [['username'],'unique'],
            [['img_file'],'file','extensions'=>['jpg','png','gif']],
            [['email'],'email'],
            [['email'],'unique'],
            [['code'],'captcha'], //验证码验证
            [['role','auth_key'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'salt' => '盐',
            'email' => '邮箱',
            'token' => '自动登陆令牌',
            'token_carete_time' => '令牌创建时间',
            'add_time' => '注册时间',
            'last_login_time' => '最后登陆时间',
            'last_login_ip' => '登陆ip',
            'img_file'=>'上传头像',
             'code'=>'验证码',
            'auth_key' => 'Auth Key',
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
    }



    //获取所有的角色
    public static function getRole(){
        // 实例化组件
        $authManager=\Yii::$app->authManager;
        //获取所有的角色
        $role = $authManager->getRoles();
        return ArrayHelper::map($role,'name','description');
    }

    public function getMenuItems(){
        $menuItems=[];
        //获取到所有的一级菜单
        $query=Menu::find();
        $menus=$query->where(['parent_id'=>0])->all();
        //循环所有的菜单
        foreach($menus as $menu){
            $items=[];
            foreach($menu->menus as $child){
                     //看当前角色 是否有该权限
                   if(Yii::$app->user->can($child->url)){
                        $items[] = ['label' => $child->name, 'url' => [$child->url]];
                   }
            }
            //如果没有权限 就不拼接菜单栏
          if(!empty($items)){
                $menuItems[] = [
                    'label' => $menu->name,
                    'items' => $items,
                ];

            }

        }
        return $menuItems;


    }
            /*'label' => '商品管理',
            'items' => [
            ['label' => '商品列表', 'url' => ['goods/index']],
            ['label' => '添加商品', 'url' => ['goods/add']],
            ]*/

}
