<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5 0005
 * Time: 下午 12:47
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name; //名字(路由)
    public $description; //描述


    //验证规则
    public function rules()
    {
        return [
            [['name','description'],'required'],
            [['name'],'string','max'=>50],
            [['description'],'string','max'=>50],
            [['name'],'validateName']
        ];
    }


    public function attributeLabels()
    {
        return [
            'name'=>'权限名(路由)',
            'description'=>'描述',
        ];
    }

    //  自定义验证  方法
    public function validateName()
    {
        //实例化组件
        $authManager= \Yii::$app->authManager;
        if ($authManager->getPermission($this->name)){
           return $this->addError('name','权限已存在');
        }
    }

    //自定义保存方法
    public function add(){
        //实例化组件
        $authManager=\Yii::$app->authManager;
        //创建权限
        $Permission=$authManager->createPermission($this->name);
        //添加权限描述
        $Permission->description=$this->description;
        //保存权限   返回布尔值
       return $authManager->add($Permission);
    }
}