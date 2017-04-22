<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;

class RbacController extends \yii\web\Controller
{
    //权限列表
    public function actionIndex()
    {
        // 1.实例化 组件
        $authManager = \Yii::$app->authManager;
        // 2.获取所有权限
        $permissions = $authManager->getPermissions();
        //可以调用其它视图显示    加上试图的路径  admin/index
        return $this->render('permissionindex', ['permissions' => $permissions]);
    }

    //添加权限
    public function actionPermissionAdd()
    {
        //实例化表单模型
        $model = new PermissionForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->add()){
                // 4.添加成功提示信息
                \Yii::$app->session->setFlash('info', $model->description . '添加成功');
                // 5.跳转页面
                return $this->redirect(['rbac/index']);
            }

        }
        return $this->render('permissionadd', ['model' => $model]);
    }

    //权限的删除
    public function actionPermissionDel($name)
    {
        // 1.实例化 组件
        $authManager = \Yii::$app->authManager;
        // 2.根据条件获取 数据
        $permission = $authManager->getPermission($name);
        // 2.删除数据
        $authManager->remove($permission);
        // 2.删除成功返回列表页面
        \Yii::$app->session->setFlash('danger','删除'.$name.'成功');
        return $this->redirect(['rbac/index']);
    }

    // 角色列表
    public function actionRole(){
        //实例化组件
        $authManager=\Yii::$app->authManager;
        //得到所有的角色
        $roles = $authManager->getRoles();
        //返回试图 和 数据
        return $this->render('role',['roles'=>$roles]);

    }

    // 角色添加
    public function actionRoleAdd()
    {
            // 1.实例化表单
        $model = new RoleForm();
          // 2.指定场景
        $model->scenario=RoleForm::SCENARIO_ADD;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->add();
            \Yii::$app->session->setFlash('info','添加角色成功');
           return $this->redirect(['rbac/role']);
        }
        return $this->render('roleadd',['model'=>$model]);
    }

    //角色删除
    public function actionRoleDel($name){
        $authManager=\Yii::$app->authManager;
        $role= $authManager->getRole($name);
        $authManager->remove($role);
        \Yii::$app->session->setFlash('info','删除成功');
        return $this->redirect(['rbac/role']);

    }

    //角色的修改
    public function actionRoleEdit($name){
        // 1. 创建表单模型
        $model= new RoleForm();
        // 2. 实例化 组件
        $authManager=\Yii::$app->authManager;
        // 3.根据传过来的 name 查询数据
        $roles = $authManager->getRole($name);
        //调用模型上面的方法处理数据
        $model->loadRole($roles);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            //调用模型上面的修改方法
            $model->edit($roles);
            //提示信息
            \Yii::$app->session->setFlash('info','更新角色成功');
            //跳转页面
            return $this->redirect(['rbac/role']);
        }
        return $this->render('roleadd',['model'=>$model]);

    }
         public function behaviors()
        {
        return [
            'accessfilter'=>[
                'class'=>AccessFilter::className(),
            ],
        ];
    }



}
