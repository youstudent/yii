<?php

namespace backend\controllers;
use backend\filters\AccessFilter;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\LoginForm;
use backend\models\SearchForm;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use xj\uploadify\UploadAction;
use backend\models\Goods;
use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class GoodsController extends \yii\web\Controller
{
    //展示列表页面
    public function actionIndex()
    {
        $search=new SearchForm();
        $query= Goods::find()->where(['>','status',0]);
        $search->search($query);
        $count=$query->count();
        $pager= new Pagination([
            'totalCount'=>$count,
            'pageSize'=>5
        ]);
        $models= $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager,'search'=>$search]);
    }

    //商品的添加
    public function actionAdd(){
        $model=new Goods();
        $goodsday= new GoodsDayCount();
        $content=new GoodsIntro();
        $request= new Request();
        if($request->isPost){
          $model->load($request->post());
           $load= GoodsCategory::findOne(['id'=>$model->goods_category_id]);
           if ($load->depth<2){
               \Yii::$app->session->setFlash('danger','请选择第三极分类');
               return $this->refresh();
           }
          $content->load($request->post());
            //验证规则
            $counts = GoodsDayCount::findOne(['day'=>date('Y-m-d')]);
            if($counts){
                $counts->count= $counts->count+1;
                $counts->save();
            }else{
                $goodsday->day=date('Y-m-d');
                $goodsday->count=1;
                $goodsday->save();
            }
            if($model->validate() && $content->validate() ){
              $model->inputtime = time(); //添加当前时间
              $model->save(); //保存数据
              $content->goods_id=$model->id;
              $content->save();
              \Yii::$app->session->setFlash('info','添加商品成功!!请添加相册');
              return $this->redirect(['goods/photo','id'=>$model->id]);
          }

        }
        $models=GoodsCategory::find()->all();
        $models= Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models,'content'=>$content]);

    }
    //商品的修改
    public function actionEdit($id){
        $model= Goods::findOne(['id'=>$id]);
        $content=GoodsIntro::findOne(['goods_id'=>$id]);
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            $content->load($request->post());
            $load= GoodsCategory::findOne(['id'=>$model->goods_category_id]);
            if ($load->depth<2){
                \Yii::$app->session->setFlash('danger','请选择第三极分类');
                return $this->refresh();
            }
            //验证规则
            if($model->validate() && $content->validate() ){
                $model->save(); //保存数据
                $content->goods_id=$model->id;
                $content->save();
                return $this->redirect(['goods/photo','id'=>$model->id]);
            }

        }
        $models=GoodsCategory::find()->all();
        $models= Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models,'content'=>$content]);
    }
    //删除商品
    public function actionDel($id){
        $model=Goods::findOne(['id'=>$id]);
        $model->status=0;
        $model->save();
        \Yii::$app->session->setFlash('danger','删除成功!!删除数据在回收站');
        return $this->redirect(['goods/index']);

    }
    //回收站
    public function actionBin(){
        $query= Goods::find()->where(['=','status',0]);
        $count = $query->count();
        $pager=new Pagination([
            'totalCount'=>$count,
            'pageSize'=>1
        ]);
        $models=$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('bin',['models'=>$models,'pager'=>$pager]);
    }
    //回收站永久删除
    public function actionBindel($id){
        GoodsGallery::deleteAll(['goods_id'=>$id]);
        Goods::deleteAll(['id'=>$id]);
        GoodsIntro::deleteAll(['goods_id'=>$id]);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['goods/bin']);
    }
    //回收站恢复数据
    public function actionBinedit($id){
        $model = Goods::findOne(['id'=>$id]);
        $model->status=1;
        $model->save();
        \Yii::$app->session->setFlash('danger','恢复成功');
        return $this->redirect(['goods/bin']);
    }

    //商品图片的上
    public function actionPhoto($id)
    {
        $gallery = new GoodsGallery();
        $request = new Request();
        if ($request->post()) {
            $gallery->load($request->post());
            $gallery->logo_file =UploadedFile::getInstances($gallery,'logo_file');
            if ($gallery->validate()){
                foreach($gallery->logo_file as $logo_file){
                    $fileName = 'upload/goods/'.uniqid().'.'.$logo_file->extension;
                    if($logo_file->saveAs($fileName,false)){
                        $g = new GoodsGallery();
                        $g->goods_id=$id;
                        $g->path=$fileName;
                        $g->save(false);
                    };
                }
                 \Yii::$app->session->setFlash('info','添加相册成功');
                $model = GoodsGallery::find()->where(['goods_id'=>$id])->all();
                return $this->render('photo',['model'=>$model]);
            }

        }
        return $this->render('file', ['gallery' => $gallery]);
    }
    //相册的查看
    public function actionPhotolist($id){
       $model = GoodsGallery::find()->where(['goods_id'=>$id])->all();
       return $this->render('photo',['model'=>$model,'ids'=>$id]);
    }

    //相册的删除
    public function actionPhotodel($id,$ids){
        GoodsGallery::deleteAll(['id'=>$id]);
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['goods/photolist','id'=>$ids]);

    }

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/goods',
                'baseUrl' => '@web/upload/goods',
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
                    $qiniu = \Yii::$app->qiniu;
                    $qiniu->uploadFile($action->getSavePath(),$action->getFilename());//将本地图片上传到七牛云
                    $url = $qiniu->getLink($action->getFilename());//获取图片在七牛云上的url地址
                    $action->output['fileUrl'] = $url;//将七牛云图片地址返回给前端js
                },
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]

        ];
    }
   /* public function behaviors()
    {
        return [
            'accessfilter'=>[
                'class'=>AccessFilter::className(),
            ],
        ];
    }*/


}
