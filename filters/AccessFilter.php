<?php

class AccessFilter extends \yii\base\ActionFilter
{
    //操作执行之前执行的代码
    public function beforeAction($action){
      //判断当前是否有操作该权限  can
      if(!Yii::$app->user->can($action->uniqueId)){

      }


    }

}