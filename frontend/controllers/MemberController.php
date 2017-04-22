<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\Chit;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\filters\AccessControl;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use yii\helpers\Json;

class MemberController extends \yii\web\Controller
{
    public $layout = 'login';//指定模板文件

    public function actionIndex()
    {
        return $this->render('index');
    }


    //用户注册
    public function actionAdd()
    {
        $model = new Member();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->password=\Yii::$app->security->generatePasswordHash($model->password);
            $model->add_time=time();//添加注册时间
            $model->last_login_ip=$_SERVER['REMOTE_ADDR'];//获取ip地址
            $model->last_login_time=time();//最后登陆时间
            $model->save(false); //保存数据
            \Yii::$app->user->login($model);  //注册成功自动登陆
            return$this->redirect(['address/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    //登陆
    public function actionLogin(){
       $model =new LoginForm();
       if ($model->load(\Yii::$app->request->post()) && $model->validate()){
           //调用调用对象上面的方法
           if ($model->login()){
              //将cookies中的值取出来 保存到 数据库中
               $cookies=\Yii::$app->request->cookies;
               $cart= $cookies->get('cart');
               if ($cart != null){
                   //将取出来的数据反序列化
                   $carts = unserialize($cart->value);
                   //循环 cookies中的数据
                   foreach ($carts as $k=>$cart){
                       // 根据 用户id和 商品id  到数据库中查找数据
                       $data = Cart::findOne(['goods_id'=>$k,'member_id'=>\Yii::$app->user->id]);
                       //如果查询到 该用户有该商品    就将该商品的数量加上cookies取出来的数据
                       if ($data){
                           $data->num +=$cart;
                           $data->save(false);
                       }else{
                           //如果没有    就把该商品 直接保存到数据库中
                           //创建模型对象
                           $model =new Cart();
                           $model->goods_id=$k;
                           $model->member_id=\Yii::$app->user->id;
                           $model->num=$cart;
                           $model->save();
                       }

                   }
                   //清除cookies     如果不清除cookies  下次登陆 就会重复保存到数据库
                  \Yii::$app->response->cookies->remove('cart');

               }
             \Yii::$app->session->setFlash('info','登陆成功');
             return $this->redirect(['address/index']);
           }

       }

       return $this->render('login',['model'=>$model]);

    }
    //退出登录
    public function actionLogout(){
        \Yii::$app->user->logout();

    }


    //获取登陆用户信息
    public function actionTest(){
        $rows =\Yii::$app->user->isGuest;
        var_dump($rows);
        //$row = \Yii::$app->user->getIdentity();
        //var_dump($row);
    }

    //短信接收验证
    public  static function actionCode(){
        //接收js数据
        $tel = \Yii::$app->request->post('tel');
        //$tel = 13219890986;
        // 1.>> 防止短信被刷
        /**
         * tel手机号   times 发送次数  date日期
         * 13219890986   1              2017-4-16
         */
        // 2.>> 发送短信前 根据手机号码 查询今天发送短信的次数
          $date =date('Y-m-d');//当前日期
          $chit = Chit::findOne(['tel'=>$tel]);
          if ($chit == null && $tel !== null){
              $model = new Chit();
              $model->tel=$tel;
              $model->times = 1;
              $model->date = $date;
              $model->save(false);
          };
        // 3.>> 如果今天有记录times就加上1  如果没有就创建(今天)一条记录 times=1
          if ($chit->date !=$date){
              $chit->times = 1;
              $chit->date=$date;//今天日期
              $chit->save(false); //保存数据

          };
          if ($chit->times <4){
              $chit->times+=1;
              $chit->save(false);
              // 4.>> 如果
              $code = rand(10000,99999);
              \Yii::$app->session->set('tel'.$tel,$code);
              Member::code($tel,$code);
          }else {
              $model = new Member();
              $model->addError('tel', '短信发送超过三次!请明天再试');
          }
    }


    //地址美化配置文件中 修改地址重写
     public function actionTests(){
        //将数组转化才 json格式
        //Json::encode()
     }

}
