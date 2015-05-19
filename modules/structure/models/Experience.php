<?php

namespace app\modules\structure\models;

use Yii;

/**
 * This is the model class for table "employee_position".
 *
 * @property integer $employee_id
 * @property integer $position_id
 * @property integer $start
 * @property integer $stop
 */
class Experience extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'position_id'], 'required'],
            [['employee_id', 'position_id', 'start', 'stop'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => Yii::t('structure', 'Employee ID'),
            'position_id' => Yii::t('structure', 'Position ID'),
            'start' => Yii::t('structure', 'Start'),
            'stop' => Yii::t('structure', 'Stop'),
        ];
    }
}
