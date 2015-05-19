<?php

namespace app\modules\structure\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tbl_department".
 *
 * @property integer $id
 * @property string $department
 * @property integer $department_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Department[] $child
 * @property Department $parent
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%department}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getChild()
    {
        return $this->hasMany(Department::className(),['department_id'=>'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Department::className(), ['id'=>'department_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department'], 'required'],
            [['department'], 'string'],
            [['department_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('structure', 'ID'),
            'department' => Yii::t('structure', 'Department'),
            'department_id' => Yii::t('structure', 'Head department'),
            'created_at' => Yii::t('structure', 'Created At'),
            'updated_at' => Yii::t('structure', 'Updated At'),
        ];
    }
}
