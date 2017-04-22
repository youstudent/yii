<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/1 0001
 * Time: 下午 10:40
 */

namespace backend\models;


use Symfony\Component\CssSelector\Parser\Handler\HashHandler;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $code; //验证码
    public $remember;

    //验证规则
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['code'],'captcha'], //验证码验证
            [['remember'],'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'remember'=>'记住我',
            'code'=>'验证码',
        ];
    }

    public function Login(){
        //验证规则
        if ($this->validate()){
           //根据用户名查找到用户信息
              $count = Admin::findOne(['username'=>$this->username]);
             if ($count){
                 //如果查询到了 用户信息就 对比密码
                 if(\Yii::$app->security->validatePassword($this->password,$count->password)){
                     //登陆成功 保存session
                      \Yii::$app->user->login($count,$this->remember?3600*24*7:0);//同时设置过期时间
                       $model= Admin::findOne(['username'=>$this->username]);
                       $model->last_login_time=time();
                       $model->save(false);
                       return true;
                 }else{
                     $this->addError('password','密码不正确');
                 }
             }else{
                 $count = Admin::findOne(['email'=>$this->username]);
                 //如果通过用户名没有查询到数据  就添加错误
                 if ($count){
                     if(\Yii::$app->security->validatePassword($this->password,$count->password)){
                         //登陆成功 保存session
                         \Yii::$app->user->login($count,$this->remember?3600*24*7:0);
                         $model= Admin::findOne(['email'=>$this->username]);
                         $model->last_login_time=time();
                         $model->save(false);
                         return true;
                     }else{
                         $this->addError('password','密码不正确');
                     }

             }else{
                     $this->addError('username','用户名或邮箱不存在');

                 }
             }
       }
        return false;

    }

}