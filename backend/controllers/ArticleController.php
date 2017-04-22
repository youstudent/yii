<?php

namespace backend\controllers;
use backend\filters\AccessFilter;
use backend\models\Article;
use backend\models\Detail;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query= Article::find();
        $count = $query->count();
        $pager=new Pagination([
            'totalCount'=>$count,
            'pageSize'=>1,
        ]);
        $models =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //文章分类的添加
    public function actionAdd(){
        $model= new Article();
        $detail=new Detail();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $detail->load($request->post());
            if($model->validate() && $detail->validate()){
                $model->inputtime=time();
                $model->save();
                $detail->id=$model->id;
                $detail->save();
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'detail'=>$detail]);

    }
    //文章的修改
    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $detail= Detail::findOne(['id'=>$id]);
        $request = new Request();
        if ($request->isPost){
            $model->load($request->post());
            $detail->load($request->post());
            //验证规则
            if($model->validate() && $detail->validate()){
                $model->save();
                $detail->id=$model->id;
                $detail->save();
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',['model'=>$model,'detail'=>$detail]);
    }

    //删除文章
    public function actionDel($id){
        Article::deleteAll(['id'=>$id]);
        Detail::deleteAll(['id'=>$id]);
        return $this->redirect(['article/index']);

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
