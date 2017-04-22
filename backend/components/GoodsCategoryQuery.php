<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/30 0030
 * Time: 下午 2:41
 */

namespace backend\components;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class GoodsCategoryQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

}