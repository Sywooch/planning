<?php

namespace app\modules\structure\models;

use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%position}}".
 *
 * @property integer $id
 * @property string $position
 * @property integer $weight
 * @property integer $chief
 * @property boolean $municipal
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

    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'weight'
            ]
        ];
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
            [['position'], 'unique'],
            [['municipal', 'chief'], 'integer'],
            [['municipal', 'chief'], 'in', 'range' => [0,1]]
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
            'weight' => Yii::t('app', 'Weight'),
            'municipal' => Yii::t('structure', 'Municipal position'),
            'chief' => Yii::t('structure', 'Head position')
        ];
    }
}
