<?php

namespace app\modules\structure\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employee_position".
 *
 * @property integer $employee_id
 * @property integer $position_id
 * @property integer $start
 * @property integer $stop
 */
class Experience extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%experience}}';
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
            'employee_id' => 'Employee',
            'position_id' => 'Position',
            'start' => Yii::t('app', 'Start'),
            'stop' => Yii::t('app', 'Stop'),
        ];
    }
}
