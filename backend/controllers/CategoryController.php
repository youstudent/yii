<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Category;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Request;

class CategoryController extends \yii\web\Controller
{
    //列表首页
    public function actionIndex()
    {
        $query= Category::find();
        $count = $query->count();
        $pager=new Pagination([
         'totalCount'=>$count,
          'pageSize'=>3,
        ]);
        $models =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    public function actionAdd(){
        $model= new Category();
        $request=new Request();
        if ($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    //删除
    public function actionDel($id){
           Category::deleteAll(['id'=>$id]);
          return $this->redirect(['category/index']);
    }
    //修改
    public function actionEdit($id){
        $model= Category::findOne(['id'=>$id]);
        $request = new Request();
        if ($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['category/index']);
            }

        }

        return $this->render('add',['model'=>$model]);

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
