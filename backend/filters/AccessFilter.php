<?php

namespace backend\filters;
use GuzzleHttp\Psr7\Request;
use yii\base\ActionFilter;
use yii\web\HttpException;

//自定义过滤器
class AccessFilter  extends ActionFilter
{
    //在动作行为开始前
    public function beforeAction($action)
    {
        //判断当前用户是否有当前操作权限
        if (!\Yii::$app->user->can($action->uniqueId)){

            //如果是游客  就跳转到登陆页面
            if (\Yii::$app->user->isGuest){
             return $action->controller->redirect(\Yii::$app->user->loginUrl);
            }
            //抛出异常
            throw new HttpException(403,'对不起你没有该访问权限');
            //返回 false 不执行
            return false;
        }
        return parent::beforeAction($action);

    }


}