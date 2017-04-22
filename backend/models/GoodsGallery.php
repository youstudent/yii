<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_gallery".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $path
 */
class GoodsGallery extends \yii\db\ActiveRecord
{
    public $logo_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logo_file'], 'required'],
            [['goods_id'], 'integer'],
            //[['path'], 'required'],
            [['path'], 'string', 'max' => 255],
            [['logo_file'],'file','extensions'=>['jpg','png','gif'],
            'maxFiles'=>3,//最大
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'path' => '商品图片地址',
            'logo_file'=>'图片'
        ];
    }
}
