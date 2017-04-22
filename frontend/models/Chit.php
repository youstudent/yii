<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "chit".
 *
 * @property integer $id
 * @property integer $tel
 * @property integer $times
 * @property string $date
 */
class Chit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tel', 'times'], 'integer'],
            [['date'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tel' => '电话号码',
            'times' => '发送次数',
            'date' => '日期',
        ];
    }
}
