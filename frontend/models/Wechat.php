<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/22 0022
 * Time: 下午 10:19
 */

namespace frontend\models;


use backend\models\Goods;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use yii\base\Model;

class Wechat extends Model
{
    public static function mei(){
        $result=[];
        $articles = [
            ['title'=>'第一名','Description'=>'我好喜欢你','PicUrl'=>'http://59.110.156.207/img/IMG_0075.JPG','Url'=>'www.baidu.com'],
            ['title'=>'第二名','Description'=>'我好喜欢你','PicUrl'=>'http://59.110.156.207/img/IMG_0023.JPG','Url'=>''],
            ['title'=>'第三名','Description'=>'','PicUrl'=>'http://59.110.156.207/img/IMG_0026.JPG','Url'=>''],
            ['title'=>'第四名','Description'=>'','PicUrl'=>'http://59.110.156.207/img/IMG_0035.JPG','Url'=>''],
            ['title'=>'第五名','Description'=>'','PicUrl'=>'http://59.110.156.207/img/IMG_0068.JPG','Url'=>''],
            ['title'=>'第六名','Description'=>'','PicUrl'=>'http://59.110.156.207/img/IMG_0073.JPG','Url'=>''],
            ['title'=>'第七名','Description'=>'','PicUrl'=>'http://59.110.156.207/img/IMG_0074.JPG','Url'=>''],
            ['title'=>'第八名','Description'=>'','PicUrl'=>'http://59.110.156.207/img/m.jpg','Url'=>''],
        ];
        foreach ($articles as $k=>$article){
            $news = new News([
                'title'=>$article['title'],
                'description' =>$article['Description'],
                'url'=> $article['Url'],
                'image'=>$article['PicUrl'],
            ]);
            $result[]=$news;

        }
        return $result;

    }

    public static function weather($Content='成都'){
        $weathers = simplexml_load_file('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
        $sichuan = [];
        $sichuan['Content'] = '该服务正在开发中';
        foreach ($weathers as $weather) {
            if ($weather['cityname'] == $Content) {
                $sichuan['stateDetailed'] = (string)$weather['stateDetailed'];//天气状况
                $sichuan['tem2'] = (string)$weather['tem2'];//最高气温
                $sichuan['tem1'] = (string)$weather['tem1'];//最低气温
                $sichuan['cityname'] = (string)$weather['cityname'];//城市
                $sichuan['Content'] = (string)$weather['cityname'];

            }

        }
        return $sichuan['Content'] . ' : ' . $sichuan['stateDetailed'] . '->最高气温 : ' . $sichuan['tem1'] . '->最低气温 : ' . $sichuan['tem2'];
    }

    //商品 热卖
    public static  function host(){
        $goods= Goods::find()->orderBy(['inputtime'=>SORT_DESC])->limit(5)->all();
        if ($goods){
            $re=[];
            foreach ($goods as $good){
                $news = new News([
                    'title'=>'商品名: '.$good->name.'  '.'良心价: '.$good->shop_price,
                    'description' =>'',
                    'url'=> 'www.baidu.com',
                    'image'=>$good->logo,
                ]);
                $re[]=$news;
            }
          return $re;
        }else{
           return '还没有商品敬请期待';
        }

    }

    //帮助信息
    public function bang(){

    }


    //获取 openid
    public static function getopenid(){
        if (!\Yii::$app->session->get('openid')){
            $app = new Application(\Yii::$app->params['wechat']);
            //发起网页授权
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            //保存当前地址到session中
            \Yii::$app->session->setFlash('back',['wechat/user']);
            $response->send();
        }

    }

}