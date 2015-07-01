<?php

namespace app\modules\structure\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%experience}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $start
 * @property string $stop
 * @property integer $staff_unit_id
 */
class Experience extends ActiveRecord
{
    public $department;
    public $position;
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
            [['employee_id', 'staff_unit_id'], 'required'],
            [['employee_id', 'staff_unit_id'], 'integer'],
            [['start', 'stop', 'position'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('structure', 'ID'),
            'employee_id' => Yii::t('structure', 'Employee ID'),
            'start' => Yii::t('structure', 'Start'),
            'stop' => Yii::t('structure', 'Stop'),
            'staff_unit_id' => Yii::t('structure', 'Staff Unit ID'),
        ];
    }
}
