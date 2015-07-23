<?php

namespace app\modules\planning\models;

use Yii;

/**
 * This is the model class for table "{{%transfer}}".
 *
 * @property integer $number
 * @property integer $action_id
 * @property string $old_start
 * @property string $old_stop
 * @property string $old_place
 * @property string $note
 *
 * @property Action $action
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'action_id'], 'required'],
            [['number', 'action_id'], 'integer'],
            [['old_start', 'old_stop'], 'safe'],
            [['note'], 'string'],
            [['old_place'], 'string', 'max' => 100],
            [['number', 'action_id'], 'unique', 'targetAttribute' => ['number', 'action_id'], 'message' => 'The combination of Number and Action ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('planning', 'Number'),
            'action_id' => Yii::t('planning', 'Action ID'),
            'old_start' => Yii::t('planning', 'Old Start'),
            'old_stop' => Yii::t('planning', 'Old Stop'),
            'old_place' => Yii::t('planning', 'Old Place'),
            'note' => Yii::t('planning', 'Note'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }
}
