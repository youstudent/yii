<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\GoodsCategory;
use backend\models\LoginForm;
use yii\data\Pagination;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
{
    //列表
    public function actionIndex()
    {
        $query=GoodsCategory::find();
        $count = $query->count(); //查询到总的条数
        //  1.创建分页对象     2.传入总条数和每夜显示的条数
        $pager=new Pagination([
             'totalCount'=>$count,
             'pageSize'=>10,
        ]);
        //构造查询条件
        $models=$query->limit($pager->limit)->offset($pager->offset)->orderBy('tree','lft')->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    /**
     *
     */

    //无限极分类的添加
    public function actionAdd(){
        $model = new GoodsCategory();
        $request = new Request();
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                 if($model->parent_id==0){
                    $model->makeRoot(); //创建一级分类
                 }else{
                     //根据传过来的parent_id    查询到上一级的数据 再把用户填写的数据追加
                     $cate = GoodsCategory::findOne(['id'=>$model->parent_id]);
                     $model->prependTo($cate);//创建子分类
                 }
                 return $this->redirect(['index']);
            }
        }
        $models=GoodsCategory::find()->all();
        //把查询到的所有数据  和总计构造的数据放到 models中
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        //再把数据转换为json格式
        $models=Json::encode($models);
        //把数据返回到页面
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }

    //删除分类
    public function actionDel($id){
        //根据   parent_id查找 如果查询到了数据说明有子分类
        if (GoodsCategory::find()->where(['parent_id'=>$id])->all()){
            //提示信息  跳转会首页,不删除数据
            \Yii::$app->session->setFlash('danger','有子分类不能删除');
            return $this->redirect('index');
        }else{
            //否则就删除数据
            GoodsCategory::deleteAll(['id'=>$id]);
            \Yii::$app->session->setFlash('info','删除成功');
            return $this->redirect('index');
        }
    }

    //分类的修改
    public function actionEdit($id){
        //根据id查询出一条数据
        $model=GoodsCategory::findOne(['id'=>$id]);
        $request = new Request();
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()){
                try{
                    if($model->parent_id==0){
                        $model->makeRoot(); //创建一级分类
                    }else{
                        //根据传过来的parent_id    查询到上一级的数据 再把用户填写的数据追加
                        $cate = GoodsCategory::findOne(['id'=>$model->parent_id]);
                        $model->prependTo($cate);//创建子分类

                    }
                }catch (Exception $e){
                     //如果上面的代码有异常就捕获
                    \Yii::$app->session->setFlash('danger',$e->getMessage());
                }
                return $this->redirect(['index']);

            }
        }
        $models=GoodsCategory::find()->all();
        //把查询到的所有数据  和总计构造的数据放到 models中
        $models[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        //再把数据转换为json格式
        $models=Json::encode($models);
        //把数据返回到页面
        return $this->render('add',['model'=>$model,'models'=>$models]);

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
