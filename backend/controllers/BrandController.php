<?php

namespace backend\controllers;
use backend\filters\AccessFilter;
use backend\models\LoginForm;
use xj\uploadify\UploadAction;
use backend\models\Brand;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
      $query = Brand::find()->where(['!=','status','-1']);
      $totalCount = $query->count();
      $pager = new Pagination([
          'totalCount'=>$totalCount,
          'pageSize'=>2,
      ]);
      $models = $query->limit($pager->limit)->offset($pager->offset)->all();

      return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }

    //添加列表页面
    public function actionAdd(){
        $model=new Brand();
        $request=new Request();
        if($request->isPost){
           $model->load($request->post());
           //$model->logo_file=UploadedFile::getInstance($model,'logo_file');
           if($model->validate()){
              /* if ($model->logo_file){
                   $fileName='upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                   $model->logo_file->saveAs($fileName,false);
                   $model->logo=$fileName;
               }*/
             $model->save(false);
             return $this->redirect(['brand/index']);
           }

        }

        return $this->render('add',['model'=>$model]);
    }

    //点击删除 改变状态值
    public function actionDel($id){
        $model =Brand::findOne(['id'=>$id]);
        $model->status= -1;
        $model->save();
        return $this->redirect(['brand/index']);
    }
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //$model->logo_file=UploadedFile::getInstance($model,'logo_file');
            if ($model->validate()){
               /* if ($model->logo_file){
                    $fileName='upload/brand/'.uniqid().'.'.$model->logo_file->extension;
                    $model->logo_file->saveAs($fileName,false);
                    $model->logo=$fileName;
                }*/
               $model->save();
                return $this->redirect(['brand/index']);
            }

        }
        return $this->render('add',['model'=>$model]);

    }
    //回收站
    public function actionBin(){
        $query=Brand::find()->where(['=','status','-1']);
        $count=$query->count();
        $pager = new Pagination([
            'totalCount'=>$count,
            'pageSize'=>2,
        ]);
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('bin',['models'=>$models,'pager'=>$pager]);

    }
    //彻底删除数据
    public function actionBindel($id){
        Brand::deleteAll(['id'=>$id]);
        return $this->redirect(['brand/bin']);
    }

    //恢复数据
    public function actionBinregain($id){

        $model=Brand::findOne(['id'=>$id]);
        $model->status=1;
        $model->save();
        return $this->redirect(['brand/bin']);

    }

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //$action->output['fileUrl'] = $action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //将图片传的七牛云上
                    $qiniu = \Yii::$app->qiniu;
                    $qiniu->uploadFile($action->getSavePath(),$action->getFilename());//将本地图片上传到七牛云
                    $url = $qiniu->getLink($action->getFilename());//获取图片在七牛云上的url地址
                    $action->output['fileUrl'] = $url;//将七牛云图片地址返回给前端js
                },
            ],
        ];
    }

    //过滤器
    public function behaviors()
    {
        return [
            'accessfilter'=>[
                'class'=>AccessFilter::className(),
            ],
        ];
    }
}
