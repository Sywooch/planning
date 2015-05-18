<?php

namespace app\modules\planning\models;

use Yii;
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
            'id' => 'ID',
            'place' => 'Place',
        ];
    }
}
