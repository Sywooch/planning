<?php

namespace app\modules\planning\models;

use app\modules\structure\models\Experience;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "action_employee".
 *
 * @property integer $action_id
 * @property integer $exp_id
 * @property integer $type
 * @property integer $visited
 * @property integer $week_approved
 * @property string $week_note
 * @property integer $month_approved
 * @property string $month_note
 *
 * @property Action $action
 * @property Experience $exp
 */
class ActionEmployee extends ActiveRecord
{
    const HEAD = 1;
    const RESPONSIBLE = 2;
    const INVITED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_id', 'exp_id', 'type'], 'required'],
            [['action_id', 'exp_id', 'type', 'visited', 'week_approved', 'month_approved'], 'integer'],
            [['week_note', 'month_note'], 'string', 'max' => 255],
            [['action_id', 'exp_id'], 'unique', 'targetAttribute' => ['action_id', 'exp_id'], 'message' => 'The combination of Action ID and Exp ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new ActionEmployeeQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'action_id' => Yii::t('planning', 'Action ID'),
            'exp_id' => Yii::t('planning', 'Exp ID'),
            'type' => Yii::t('planning', 'Type'),
            'visited' => Yii::t('planning', 'Visited'),
            'week_approved' => Yii::t('planning', 'Week Approved'),
            'week_note' => Yii::t('planning', 'Week Note'),
            'month_approved' => Yii::t('planning', 'Month Approved'),
            'month_note' => Yii::t('planning', 'Month Note'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExp()
    {
        return $this->hasOne(Experience::className(), ['id' => 'exp_id']);
    }
}
