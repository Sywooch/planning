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
 * @property string $email
 * @property integer $logic_delete
 * @property integer $created_at
 * @property integer $updated_at
 *
 * Relations properties
 * @property Phone[] $phones
 */
class Employee extends ActiveRecord
{
    const HOLDEVENT = 1;
    const RESPONSIBLE = 2;
    const INVITED = 3;

    public $_phones;
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

    public function getExperience() {
        return $this->hasMany(Experience::className(), ['employee_id' => 'id']);
    }

    public function getStaffUnit() {
        return $this->hasOne(StaffList::className(), ['id' => 'staff_unit_id'])->via('experience');
    }

    public function getPosition() {
        return $this->hasOne(Position::className(), ['id' => 'position_id'])->via('staffUnit');
    }

    public function getDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'department_id'])->via('staffUnit');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['logic_delete', 'created_at', 'updated_at'], 'integer'],
            [['fio', 'email'], 'trim'],
            [['fio'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128],
            [['email'], 'email'],
            [['phones'], 'safe'],
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
            'email' => Yii::t('structure', 'Email'),
            'logic_delete' => Yii::t('structure', 'Logic delete'),
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

    public function setPhones($value) {
        $this->_phones = $value;
    }

    public function afterSave($insert, $changedAttributes) {
        if(!empty($this->_phones)){
            foreach($this->_phones as $phone){
                $newPhone = new Phone();
                $newPhone->phone = Phone::normalize($phone['phone']);
                $newPhone->type = $phone['type'];
                $this->link('phones', $newPhone);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
