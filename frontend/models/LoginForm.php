<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9 0009
 * Time: 下午 3:13
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;//用户名
    public $password;//密码
    public $code;//验证码
    public $rember;


    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['code'],'captcha'],//验证码
            [['rember'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码'
        ];
    }

    //验证登陆
    public function login(){
        //根据用户名  查找用户信息
        $count = Member::findOne(['username'=>$this->username]);
        if ($count){
            if (\Yii::$app->security->validatePassword($this->password,$count->password)){
                //登陆成功保存session
                \Yii::$app->user->login($count,$this->rember?3600*24*7:0);

                 \Yii::$app->session->setFlash('info','登陆成功');
                 $model = Member::findOne(['username'=>$this->username]);
                 $model->last_login_time=time();
                 $model->last_login_ip=$_SERVER['REMOTE_ADDR'];
                 $model->save(false);
                 return true;
            }else{
                $this->addError('password','密码不正确');
            }
        }else{
            $this->addError('username','用户名不存在');
        }
        return false;

    }

}