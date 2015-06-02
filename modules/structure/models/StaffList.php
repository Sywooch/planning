<?php

namespace app\modules\structure\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%staff_list}}".
 *
 * @property integer $department_id
 * @property integer $position_id
 * @property integer $count
 */
class StaffList extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%staff_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'position_id'], 'required'],
            [['department_id', 'position_id', 'count'], 'integer']
        ];
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    public function getPosition() {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => Yii::t('structure', 'Department'),
            'position_id' => Yii::t('structure', 'Position'),
            'count' => Yii::t('app', 'Count'),
        ];
    }
}