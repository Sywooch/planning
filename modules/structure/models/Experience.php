<?php

namespace app\modules\structure\models;

use nepstor\validators\DateTimeCompareValidator;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "{{%experience}}".
 *
 * @property integer $id
 * @property integer $employee_id
 * @property string $start
 * @property string $stop
 * @property integer $staff_unit_id
 *
 * Related attributes
 * @property Department $relDepartment
 * @property Position $relPosition
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
            [['employee_id', 'staff_unit_id'], 'integer'],
//            ['stop', DateTimeCompareValidator::className(), 'compareAttribute' => 'start', 'format' => 'd.m.Y', 'operator' => '>', 'allowEmpty' => true],
            [['start'], 'validateDates']
        ];
    }

    public function getStuffUnit() {
        return $this->hasOne(StaffList::className(), ['id' => 'staff_unit_id']);
    }

    public function getRelPosition() {
        return $this->hasOne(Position::className(), ['id' => 'position_id'])->via('stuffUnit');
    }

    public function getRelDepartment() {
        return $this->hasOne(Department::className(), ['id' => 'department_id'])->via('stuffUnit');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'employee_id' => Yii::t('structure', 'Employee ID'),
            'start' => Yii::t('app', 'Start'),
            'stop' => Yii::t('app', 'Stop'),
            'staff_unit_id' => Yii::t('structure', 'Staff Unit ID'),
        ];
    }

    public function afterFind() {
        $this->start = Yii::$app->formatter->asDate($this->start, 'php:d.m.Y');
        if($this->stop !== null)
            $this->stop = Yii::$app->formatter->asDate($this->stop, 'php:d.m.Y');
    }

    public function beforeValidate() {
        if(empty($this->stop))
            $this->stop = null;
        return parent::beforeValidate();
    }

    public function beforeSave($insert) {
        $this->start = Yii::$app->formatter->asDate($this->start, 'php:Y-m-d H:i:s');
        if($this->stop !== null)
            $this->stop = Yii::$app->formatter->asDate($this->stop, 'php:Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }

    public function validateDates($attribute, $params) {
        $q = (new Query())
            ->from('{{%experience}}')
            ->where(['employee_id' => $this->employee_id]);
        if($this->stop !== null){
            $q->andWhere('start BETWEEN :start AND :stop')
                ->orWhere('(start <= :start AND stop >= :stop) OR (start <= :start AND start < :stop AND stop IS NULL)')
                ->orWhere('(stop BETWEEN :start AND :stop)')
                ->orWhere('(start >= :start AND stop <= :stop) OR (start >= :start AND start < :stop AND stop IS NULL)')
                ->addParams([':stop' => Yii::$app->formatter->asDate($this->stop, 'php:Y-m-d H:i:s')]);
        }
        else{
            $q->andWhere('start <= :start AND stop IS NULL')
                ->orWhere('start >= :start')
                ->orWhere('start <= :start AND stop > :start');

        }
        if(!$this->isNewRecord) {
            $q->andWhere('id <> :id', [':id' => $this->id]);
        }
        $q->addParams([
            ':start' => Yii::$app->formatter->asDate($this->start, 'php:Y-m-d H:i:s'),
        ]);
        if(!empty($q->all())){
            $this->addError($attribute, 'Неправильно выбран диапазон дат работы сотрудника!');
            $this->addError('stop', 'Неправильно выбран диапазон дат работы сотрудника!');
        }
    }
}
