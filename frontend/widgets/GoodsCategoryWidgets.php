<?php
namespace frontend\widgets;


use backend\models\GoodsCategory;
use yii\helpers\Html;

class GoodsCategoryWidgets extends \yii\base\Widget
{

    public function run()
    {
        $html = '';
        $categories = GoodsCategory::find()->where(['parent_id'=>0])->all();//获取一级分类
        //一级分类
        foreach($categories as $k=>$category){
            $html .= '<div class="cat '.($k==0?'item1':'').'">
                    <h3>'.Html::a($category->name,['list/list','id'=>$category->id,'name'=>$category->name]).'<b></b></h3>
                    <div class="cat_detail">';
            //遍历二级分类
            foreach($category->children as $child){
                $html .= '<dl class="dl_1st">
                            <dt>'.Html::a($child->name,['list/list','id'=>$child->id]).'</dt>
                            <dd>';
                //三级分类
                foreach($child->children as $cate)
                    $html .= Html::a($cate->name,['list/list','id'=>$cate->id]);

                $html .= '</dd>
                        </dl>';
            }
            $html .= '</div></div>';

        }
        return $html;
    }


}