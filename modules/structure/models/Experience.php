<?php

namespace app\modules\structure\models;

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
            [['start', 'stop', 'position'], 'safe'],
            [['start'], 'validateDates']
        ];
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
        $this->stop = ($this->stop !== null)?Yii::$app->formatter->asDate($this->stop, 'php:d.m.Y'):null;
    }

    public function beforeSave($insert) {
        $this->start = Yii::$app->formatter->asDate($this->start, 'php:Y-m-d H:i:s');
        $this->stop = Yii::$app->formatter->asDate($this->stop, 'php:Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }

    public function validateDates($attribute, $params) {
        $q = (new Query())
            ->from('{{%experience}}')
            ->where(['employee_id' => $this->employee_id])
            ->andWhere('start < :start AND stop >= :start')
            ->orWhere('start <= :stop AND stop > :stop')
            ->orWhere('start >= :start AND stop <= :stop')
            ->orWhere('start <= :start AND stop >= :stop')
            ->addParams([
                ':start' => Yii::$app->formatter->asDate($this->start, 'php:Y-m-d H:i:s'),
                ':stop' => Yii::$app->formatter->asDate($this->stop, 'php:Y-m-d H:i:s')
            ])
            ->all();
        if(!empty($q)){
            $this->addError($attribute, 'Неправильно выбран диапазон дат работы сотрудника!');
            $this->addError('stop', 'Неправильно выбран диапазон дат работы сотрудника!');
        }
    }
}
