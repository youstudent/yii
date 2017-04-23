<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/22 0022
 * Time: 下午 5:59
 */

namespace frontend\controllers;


use backend\models\Goods;
use Codeception\Module\REST;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use frontend\models\LoginForm;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\Wechat;
use frontend\models\WechatForm;
use yii\helpers\Url;
use yii\validators\SafeValidator;
use yii\web\Controller;

class WechatController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex(){
        $app = new Application(\Yii::$app->params['wechat']);
        $server= $app->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                switch ($message->Event){
                case 'subscribe':
                    # code...
                 break;

                  case 'CLICK'://点击事件
                      if ($message->EventKey == 'V1001_TODAY_MUSIC'){
                          return  Wechat::mei();
                      }else if($message->EventKey == 'V1001_TODAY_CHENGDU') {
                          return Wechat::weather();
                      }else if ($message->EventKey == 'V1001_GOOD'){
                          return Wechat::host();
                      }
                      break;
                 }
                    return $message->EventKey;
                    break;
                case 'text':
                    if ($message->Content=='1'){
                        return Wechat::mei();
                    }else if(strpos($message->Content,'天气预报')){
                        $Content=str_replace('天气预报','',$message->Content);
                        return Wechat::weather($Content);
                    }else if ($message->Content == '0'){
                        return Wechat::host();
                    }else if ($message->Content == '解除绑定'){
                        $member= Member::findOne(['openid'=>\Yii::$app->session->get('openid')]);
                        if ($member == null){
                            return '11';
                        }else{
                           $member->openid = '';
                           $member->save();
                           //清除当前用户id
                            \Yii::$app->session->remove('openid');
                           return '解除绑定成功';
                        }
                    }else if ($message->Content == '帮助'){
                     return '查看天气预报请回复 : '.'xxx市天气预报'.'   '.'查看商品回复 : '.'0'.'  '.'查看美女回复:'.'1';
                    }

                    break;
               /* case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;*/
            }
        });

        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }

    //获取菜单
    public function actionGetMenus(){
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $menus = $menu->all();
        var_dump($menus);
    }

    //设置菜单
    public function actionSetMenus(){
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "猜你喜欢",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "type" => "click",
                "name" => "成都天气",
                "key"  => "V1001_TODAY_CHENGDU"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "我的信息",
                        // Url::to 第二个参数设置 true 就是完整路径
                        "url"  => Url::to(['wechat/user'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/order'],true)
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账号",
                        "url"  => Url::to(['wechat/bang'],true)
                    ],
                    [
                        "type" => "click",
                        "name" => "热卖商品",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        $menu->add($buttons);

    }

    //我的信息
    public function actionUser(){
        //判断有没有 openid
        if (!\Yii::$app->session->get('openid')){
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->redirect();
            //保存当前地址到session中
            \Yii::$app->session->setFlash('back','wechat/user');
            $response->send();
        }
        $member= Member::findOne(['openid'=>\Yii::$app->session->get('openid')]);
        if ($member == null){
            return $this->redirect(['wechat/bang']);
        }

        return $this->render('user',['member'=>$member]);
    }
    //我的订单
    public function actionOrder(){
        if (!\Yii::$app->session->get('openid')){
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->redirect();
            //保存当前地址到session中
            \Yii::$app->session->setFlash('back','wechat/order');
            $response->send();
        }
        $member=Member::findOne(['openid'=>\Yii::$app->session->get('openid')]);
        if ($member == null){
            return $this->redirect(['wechat/bang']);
        }
        $member_id = $member->id;

        $orders= Order::find()->where(['member_id'=>$member_id])->all();

        return $this->render('order',['orders'=>$orders]);
    }

    //回调
    public function actionCallback(){
       //获取用户的 open_id
        $app = new Application(\Yii::$app->params['wechat']);
        $user = $app->oauth->user();
        $openid= $user->id;
        //保存到session中
        \Yii::$app->session->set('openid',$openid);
        //调回请求地址   检测session中是否有 back值
        if (\Yii::$app->session->hasFlash('back')){
            //如果有就跳转到 back属性对应的值
            return $this->redirect([\Yii::$app->session->getFlash('back')]);
        }
    }

    //绑定页面
    public function actionBang(){
        //检查是否有 openid
        if (!\Yii::$app->session->get('openid')){
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->redirect();
            //保存当前地址到session中
            $response->send();
        }
        $openid=\Yii::$app->session->get('openid');
        $re = Member::findOne(['openid'=>$openid]);
        if ($re){
            \Yii::$app->user->login($re); //如果已经绑定就自动登录
            \Yii::$app->session->setFlash('info','已绑定');
            return $this->redirect(['wechat/user']);
        }
        $model = new WechatForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->login($openid)) {
                if (\Yii::$app->session->hasFlash('back')){
                    //如果有就跳转到 back属性对应的值
                    return $this->redirect([\Yii::$app->session->getFlash('back')]);
                }else{
                    \Yii::$app->session->setFlash('info','绑定成功');
                    return $this->render('jie');
                }
            }
        }
        return $this->render('login',['model'=>$model]);

    }

    //取消绑定页面
    public function actionJie(){
        $user = Member::findOne(['openid'=>\Yii::$app->session->get('openid')]);
        $user->updateAttributes(['openid'=>null]);
        //\Yii::$app->user->logout();
        \Yii::$app->session->setFlash('info','取消绑定成功');
        return $this->redirect(['wechat/bang']);

    }

}