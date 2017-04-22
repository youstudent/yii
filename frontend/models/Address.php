<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $consignee
 * @property string $address
 * @property string $detailed_address
 * @property integer $tel
 * @property integer $default
 */
class Address extends \yii\db\ActiveRecord
{
    //public $check;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'tel', 'check'], 'integer'],
            [['consignee', 'detailed_address', 'tel'], 'required'],
            [['consignee', 'detailed_address'], 'string', 'max' => 100],
            [['tel'],'match','pattern'=>'/^[1][358][0-9]{9}$/','message'=>'号码格式不对'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户ID',
            'consignee' => '* 收货人:',
            'detailed_address' => '* 详细地址:',
            'tel' => '* 手机号:',
            'check' => '默认地址',
        ];
    }
}
