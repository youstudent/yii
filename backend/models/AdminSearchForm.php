<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/3 0003
 * Time: 下午 2:11
 */

namespace backend\models;


use yii\base\Model;

class AdminSearchForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'],'string']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'用户名'
        ];
    }


    //管理员的搜索
    public function adminsearch($query){
        $this->load(\Yii::$app->request->get());
        if ($this->name){
            $query->andWhere(['like','username',$this->name]);
        }


    }

}