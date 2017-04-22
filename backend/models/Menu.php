<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $parent_id
 * @property string $description
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['name', 'parent_id', 'url'], 'string', 'max' => 255],
            [['name'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名称',
            'parent_id' => '上级分类ID',
            'description' => '简介',
            'url' => '路由',
        ];
    }
    public static function parent(){
        $parent1[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $paren2= self::findAll(['parent_id'=>0]);

        $parent=array_merge($parent1,$paren2);
        return ArrayHelper::map($parent,'id','name');

    }

    //建立一级菜单和二级菜单之间的关系
    public  function getMenus(){

        return $this->hasMany(self::className(),['parent_id'=>'id']);

    }
}
