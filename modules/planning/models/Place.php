<?php

namespace app\modules\planning\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%place}}".
 *
 * @property integer $id
 * @property string $place
 */
class Place extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%place}}';
    }

    public function __toString()
    {
        return (string)($this->id.'::'.$this->place);
    }


    /**
     * @inher
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place'], 'required'],
            [['place'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'place' => Yii::t('planning', 'Place'),
        ];
    }
}
