<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11 0011
 * Time: 下午 11:08
 */

namespace frontend\widgets;


use backend\models\Article;
use backend\models\Category;
use yii\base\Widget;

class ArticleCategoryWidgets extends Widget
{
    public function run(){
        $Article = Category::find()->where(['status'=>1])->all();
        $Html = '';
        $sn = 1;
        foreach ($Article as $active){
            $Html.='<div class="bnav'.$sn.'">
              <h3><b></b> <em>'.$active->name.'</em></h3>  
              <ul>';
             $res = Article::find()->where(['article_category_id'=>$active->id])->all();
             foreach($res as $re){
                $Html.='<li>'.$re->name.'</li>';

             }
            $Html.='</ul>
            </div>';
            $sn++;
        }
       return $Html;
    }

}