<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\data\Sort;
use yii\filters\AccessControl;

class AddressController extends \yii\web\Controller
{
    public $layout = 'address.php';

    public function actionIndex()
    {
        $model =new Address();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            if ($model->check){
                $check =  Address::findOne(['check'=>1]);
                if ($check){
                    $check->check = 0;
                    $check->save(false);
                }
            }
            $model->province=$_POST['province'];
            $model->city=$_POST['city'];
            $model->area=$_POST['area'];
            $model->member_id= \Yii::$app->user->getId();
            $model->save(false);
            return $this->refresh();
        }
        $res = Address::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index',['model'=>$model,'res'=>$res]);
    }
    //删除
    public function actionDel($id){
           Address::deleteAll(['id'=>$id]);

           return $this->redirect(['address/index']);
    }

    //设置默认地址
    public function actionCheck($id){
        $check =  Address::findOne(['check'=>1]);
        if ($check){
            $check->check = 0;
            $check->save(false);
        }
        $check =  Address::findOne(['id'=>$id]);
        $check->check =1;
        $check->save(false);
        return $this->redirect(['address/index']);
    }


}
