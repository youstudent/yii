<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Admin;
use backend\models\AdminSearchForm;
use backend\models\LoginForm;
use backend\models\SearchForm;
use backend\tests\FunctionalTester;
use phpDocumentor\Reflection\Types\Array_;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化表单
        $search = new AdminSearchForm();
        $query=Admin::find();
        //调用模型处理数据
        $search->adminsearch($query);
        //计算总条数
        $count = $query->count();
        $pager = new Pagination([
            'totalCount'=>$count,
            'pageSize'=>5,
        ]);

       $model = $query->limit($pager->limit)->offset($pager->offset)->all();
       return $this->render('index',['model'=>$model,'search'=>$search,'pager'=>$pager]);
    }

    //登陆验证
    public function actionLogin(){
        $model = new LoginForm();
        $request = new Request();
        if ($request->post()){
            $model->load($request->post());
            if ($model->login()){
                \Yii::$app->session->setFlash('info','登陆成功');
                return $this->redirect(['admin/index']);
            }
        }
       return $this->render('login',['model'=>$model]);
    }
    //添加管理员
    public function actionAdd(){
        $model= new Admin();
        $request = new Request();
        if($request->isPost){
            //实例化上传图片对象
            $model->load($request->post());
            $model->img_file = UploadedFile::getInstance($model,'img_file');
            if($model->validate()){
                if ($model->img_file){
                    $imgName='upload/admin/'.uniqid().'.'.$model->img_file->extension;
                    $model->img_file->saveAs($imgName,false);
                    $model->img=$imgName;
                }else{
                    //默认头像
                    $model->img='upload/admin/08612c13139dc9c0d803c3c1bbe99a3b7d62608c.jpg';
                }
                $model->add_time=time();
                $model->last_login_ip = $_SERVER["REMOTE_ADDR"];
                $model->last_login_time=time();
                $model->password =\Yii::$app->security->generatePasswordHash($model->password);
                $model->save(false);
                //添加角色
                if ($model->role){
                    //实例化组件
                    $authManager= \Yii::$app->authManager;
                    foreach($model->role as $options){
                        //添加 角色
                     $authManager->assign($authManager->getRole($options),$model->id);
                    }
                }

                \Yii::$app->session->setFlash('info','注册成功');
                \Yii::$app->user->login($model);
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);

    }

    //删除
    public function actionDel($id){
        if(Admin::findOne(['id'=>$id])->username==='admin'){
            \Yii::$app->session->setFlash('danger','不能删除超级管理员');
            return $this->redirect(['admin/index']);
        }
         $authManager= \Yii::$app->authManager;
         $authManager->revokeAll($id);
         Admin::deleteAll(['id'=>$id]);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['admin/index']);
    }

    //修改
    public function actionEdit($id){
         $model= Admin::findOne(['id'=>$id]);
         $authManager=\Yii::$app->authManager;
         $role = $authManager->getRolesByUser($id);
         $model->role=array_keys($role);
         $request=new Request();
          $model->img_file= UploadedFile::getInstance($model,'img_file');
         if($request->isPost){
              $model->load($request->post());
              if ($model->validate()){
                  //跟新数据
                  $model->save(false);
                  //清除角色
                 $authManager->revokeAll($id);
                  if ($model->role){
                      //实例化组件
                      //$authManager= \Yii::$app->authManager;
                      foreach($model->role as $options){
                          //添加 角色
                          $authManager->assign($authManager->getRole($options),$model->id);
                      }
                  }
                  \Yii::$app->session->setFlash('info','修改成功');
                  return $this->redirect(['admin/index']);

              }

         }

          return $this->render('add',['model'=>$model]);
    }
    //退出登录
    public function actionLogout(){
        \Yii::$app->user->logout();
        return $this->redirect(['admin/login']);
    }

    //获取用户登录信息
    public function actionGet(){
       $row =  \Yii::$app->user->getIdentity();
       var_dump($row);
    }

    public function behaviors()
    {
        return [
            'accessfilter'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','del','edit','logout','add','get']
            ],
        ];
    }

}
