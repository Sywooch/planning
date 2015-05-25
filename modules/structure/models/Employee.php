<?php

namespace app\modules\structure\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property integer $id
 * @property string $fio
 * @property integer $position_id
 * @property integer $chief
 * @property string $email
 * @property integer $department_id
 * @property integer $logic_delete
 * @property integer $weight
 * @property integer $created_at
 * @property integer $updated_at
 *
 * Relations properties
 * @property Phone[] $phones
 */
class Employee extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'department_id', 'position_id'], 'required'],
            [['position_id', 'chief', 'department_id', 'logic_delete', 'weight', 'created_at', 'updated_at'], 'integer'],
            [['fio', 'email'], 'trim'],
            [['fio'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fio' => Yii::t('structure', 'Fio'),
            'position_id' => Yii::t('structure', 'Position'),
            'chief' => Yii::t('structure', 'Chief'),
            'email' => Yii::t('structure', 'Email'),
            'department_id' => Yii::t('structure', 'Department'),
            'logic_delete' => Yii::t('structure', 'Logic delete'),
            'weight' => Yii::t('app', 'Weight'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return Phone[]
     */
    public function getPhones() {
        return $this->hasMany(Phone::className(),['employee_id'=>'id']);
    }
}
