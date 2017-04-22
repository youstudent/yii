<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5 0005
 * Time: 下午 2:49
 */

namespace backend\models;


use Behat\Gherkin\Loader\YamlFileLoader;
use Symfony\Component\CssSelector\Parser\Handler\HashHandler;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permission_options=[];

    const SCENARIO_ADD= 'add';

    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['permission_options'], 'safe'],
            [['name'], 'validateName','on'=>self::SCENARIO_ADD]

        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '角色',
            'description' => '描述',
            'permission_options' => '选择权限'
        ];
    }

    //自定义验证方法
    public function validateName()
    {
        //组件
        $authManager = \Yii::$app->authManager;
        if ($authManager->getRole($this->name)) {
            return $this->addError('name', '角色已存在');
        }
    }

    //获取 所有权限数据
    public static function getPermission()
    {
        // 实例化 组件
        $authManager = \Yii::$app->authManager;
        //获取到所有的权限
        $permissions = $authManager->getPermissions();
        //把获取到的数据 返回出去
        return ArrayHelper::map($permissions, 'name', 'description');
    }

    //自定义角色的添加
    public function add(){
        //实例化组件
        $authManager=\Yii::$app->authManager;
        //创建角色
        $Role = $authManager->createRole($this->name);
        //添加角色描述
        $Role->description=$this->description;
        //保存角色
        $authManager->add($Role);
        //给角色关联权限
        //如果需要关联 权限
        if ($this->permission_options){
            //权限可能是多个  所以要用 循环添加
            foreach ($this->permission_options as $option){
                //给角色关联权限   (角色对象   ,  权限对象)
                $authManager->addChild($Role,$authManager->getPermission($option));
            }
        }

    }

    public function loadRole(Role $role){
        $this->name=$role->name;
        $this->description=$role->description;
        $authManager=\Yii::$app->authManager;
        $permission = $authManager->getPermissionsByRole($role->name);
        $this->permission_options=array_keys($permission);
    }


    public function edit($roles){
        $authManager=\Yii::$app->authManager;
        $roles->description=$this->description;
        // 7.跟新数据
        $authManager->update($roles->name,$roles);
        // 8.添加权限前   清空之前的权限
        $authManager->removeChildren($roles);
        foreach($this->permission_options as $options){
            $authManager->addChild($roles,$authManager->getPermission($options));
        }

    }
}