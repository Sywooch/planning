<?php

namespace app\modules\structure\models;

use app\helpers\WordHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Department extends ActiveRecord
{
    public $staffListCount;

    public function __toString() {
        return $this->department;
    }
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
        return $this->hasMany(Department::className(),['department_id'=>'id'])->with('experience');
    }

    public function getParent()
    {
        return $this->hasOne(Department::className(), ['id'=>'department_id']);
    }

    public function getStaffList() {
        return $this->hasMany(StaffList::className(), ['department_id' => 'id']);
    }

    public function getExperience() {
        return $this->hasMany(Experience::className(), ['staff_unit_id' => 'id'])
            ->via('staffList')
            ->active();
    }

    /**
     * @return ActiveQuery
     */
    public function getEmployees() {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id'])
            ->joinWith('position', false)->orderBy('{{%position}}.weight')
            ->via('experience');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department'], 'required'],
            [['department'], 'trim'],
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

    public static function getDepartmentGenitive($department) {
        $wordInQuotes = false;
        $depBegin = Word::getWords(Word::ABBR);
        $matches = array_filter($depBegin, function($var) use ($department){ return preg_match("/^$var/i", $department); });
        if(count($matches)==0)
        {
            $words = explode(' ', $department);
            $_i=0;
            $properNames = Word::getWords(Word::CAPITAL);

            foreach($words as $word)
            {
                if($wordInQuotes)
                {
                    $_i++;
                    continue;
                }
                if(mb_substr($word,0,1,'UTF-8')=='«') {
                    $wordInQuotes = true;
                    $_i++;
                    continue;
                }
                if(mb_substr($word,-1,1,'UTF-8')=='»'){
                    $wordInQuotes = false;
                    $_i++;
                    continue;
                }
                $matches = array_filter($properNames, function($var) use ($word) { return preg_match("/^$var/i", $word); });
                if(count($matches)==0)
                    $words[$_i]=mb_strtolower($word, "UTF-8");
                $words[$_i]=WordHelper::Genitive($words[$_i]);
                $_i++;
            }
            return implode(' ', $words);
        }
        return $department;
    }
}