<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Category;
use backend\models\Menu;

class MenuController extends \yii\web\Controller
{
    //列表页面
    public function actionIndex()
    {
        //查询数据
        $models = Menu::find()->all();
        return $this->render('index',['models'=>$models]);
    }

    //菜单的添加
    public function actionAdd()
    {
        // 实例化模型
        $model = new Menu();
        //验证规则 接收数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //保存数据
            $model->save();
            \Yii::$app->session->setFlash('info', '添加成功');
            //跳转列表页面
            return $this->redirect(['menu/index']);
        }
        return $this->render('add', ['model' => $model]);

    }

    //修改菜单
    public function actionEdit($id){
        // 实例化模型
        $model = Menu::findOne(['id'=>$id]);
        //验证规则 接收数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //保存数据
            $model->save();
            \Yii::$app->session->setFlash('info', '修改成功');
            //跳转列表页面
            return $this->redirect(['menu/index']);
        }
        return $this->render('add', ['model' => $model]);

    }

    //删除
    public function actionDel($id){
        //删除数据
        Menu::deleteAll(['id'=>$id]);
        //删除提示
        \Yii::$app->session->setFlash('info','删除数据成功');
        return $this->redirect(['menu/index']);
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
