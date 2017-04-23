<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23 0023
 * Time: 上午 11:16
 */

namespace frontend\models;


use yii\base\Model;

class WechatForm extends Model
{

    public $username;//用户名
    public $password;//密码

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }

    public function login($openid)
    {
        //根据用户名  查找用户信息
        $count = Member::findOne(['username' =>$this->username]);
        if ($count) {
            if (\Yii::$app->security->validatePassword($this->password, $count->password)) {
                //登陆成功保存session
                \Yii::$app->user->login($count);
                $count->updateAttributes(['openid'=>$openid]);
                return true;
            } else {
                $this->addError('password', '密码不正确');
            }
        } else {
            $this->addError('username', '用户名不存在');
        }
        return false;

    }
}