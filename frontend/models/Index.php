<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12 0012
 * Time: 上午 11:06
 */

namespace frontend\models;




use backend\models\Goods;
use yii\db\ActiveRecord;

class Index extends ActiveRecord
{
    public static function xinpin(){
        $xinpin =Goods::find()->orderBy(['id'=>SORT_DESC])->limit(5)->all();
        return $xinpin;

    }

}