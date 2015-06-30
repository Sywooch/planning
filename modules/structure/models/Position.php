<?php

namespace app\modules\structure\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%position}}".
 *
 * @property integer $id
 * @property string $position
 * @property integer $weight
 */
class Position extends ActiveRecord
{
    public function __toString() {
        return $this->position;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position', 'weight'], 'required'],
            [['position'], 'trim'],
            [['position'], 'string', 'max' => 255],
//            [['weight'], 'default', 'value'=>1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('structure', 'Position'),
            'weight' => Yii::t('app', 'weight'),
        ];
    }
}
