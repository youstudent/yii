<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/3 0003
 * Time: 上午 12:10
 */

namespace backend\models;


use yii\base\Model;

class SearchForm extends Model
{
    public $sn;
    public $name;
    public $maxprice; //最大价格
    public $minprice;//最小价格


    //验证规则
    public function rules()
    {
        return [
            [['name'],'string','max'=>50],
            [['sn'],'string'],
            [['minprice'],'string'],
            [['maxprice'],'string'],
        ];
    }

    //字段名
    public function attributeLabels()
    {
        return [
          'name'=>'商品名',
            'sn'=>'货号',
            'maxprice'=>'最大',
            'minprice'=>'最小'
        ];
    }

    //搜索
    public function search($query){
        $this->load(\Yii::$app->request->get());
        if ($this->name){
            $query->andWhere(['like','name',$this->name]);
        }
        if ($this->sn){
            $query->andWhere(['like','sn',$this->sn]);
        }
        if ($this->minprice){
            $query->andWhere(['>=','shop_price',$this->minprice]);
        }
        if ($this->minprice){
            $query->andWhere(['<=','shop_price',$this->maxprice]);
        }
    }



}