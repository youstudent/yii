<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $status
 * @property integer $sort
 */
class Brand extends \yii\db\ActiveRecord
{
    //public $logo_file;
    public static $status_options=['-1'=>'删除',0=>'隐藏',1=>'正常'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','logo'], 'required'],
            [['intro'], 'string'],
            [['status', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
            //[['logo_file'],'file','extensions'=>['jpg','png','gif']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名',
            'intro' => '简介',
            //'logo' => 'LOGO',
            'status' => '状态',
            'sort' => '排序',
        ];
    }
}
