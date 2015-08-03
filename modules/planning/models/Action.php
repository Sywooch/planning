<?php

namespace app\modules\planning\models;

use app\models\User;
use app\modules\structure\models\Employee;
use app\modules\structure\models\Experience;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%action}}".
 *
 * @property integer $id
 * @property string $dateStart
 * @property string $dateStop
 * @property integer $category_id
 * @property string $action
 * @property integer $user_id
 * @property integer $week_status
 * @property integer $confirmed
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $month_status
 * @property integer $month
 * @property integer $week
 * @property integer $template
 * @property string $repeat
 * @property string $type
 *
 * @property ActionEmployee[] $actionEmployees
 * @property Experience[] $employeesExp
 * @property Flag[] $flags
 * @property Place[] $places
 * @property User $author
 * @property Category $category
 * @property ActionFile[] $actionFiles
 * @property Log[] $logs
 * @property Transfer[] $transfers
 */
class Action extends ActiveRecord
{
    const MONTH = 'month';
    const WEEK = 'week';
    public $placesAdd;
    public $flagsAdd;
    public $headEmployees;
    public $responsibleEmployees;
    public $invitedEmployees;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateStart', 'dateStop', 'action'], 'required', 'on' => [self::MONTH, self::WEEK]],
            [['dateStart', 'dateStop', 'flagsAdd', 'headEmployees', 'responsibleEmployees', 'invitedEmployees',  'placesAdd', 'user_id'], 'safe', 'on' => [self::MONTH, self::WEEK]],
            [['category_id'], 'integer'],
            [['category_id'], 'required', 'on' => self::MONTH],
            [['category_id'], 'in', 'range' => Category::getCategoriesId()],
            [['action'], 'string'],
//            [['repeat'], 'string', 'max' => 255]
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dateStart' => Yii::t('app', 'Start'),
            'dateStop' => Yii::t('app', 'Stop'),
            'category_id' => Yii::t('planning', 'Category'),
            'action' => Yii::t('planning', 'Action name'),
            'user_id' => Yii::t('planning', 'Author'),
//            'week_status' => Yii::t('planning', 'Week action approved'),
            'confirmed' => Yii::t('planning', 'Confirmed'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
//            'month_status' => Yii::t('planning', 'Month action approved'),
            'month' => Yii::t('planning', 'Month action'),
            'week' => Yii::t('planning', 'Week action'),
            'template' => Yii::t('planning', 'Template'),
            'repeat' => Yii::t('planning', 'Repeat'),
        ];
    }

    public function afterFind()
    {
        $this->dateStart = Yii::$app->formatter->format($this->dateStart, ['date', 'php:d.m.Y H:i']);
        $this->dateStop = Yii::$app->formatter->format($this->dateStop, ['date', 'php:d.m.Y H:i']);
        if(in_array($this->scenario, [self::MONTH, self::WEEK])){
            $this->flagsAdd = self::getIds($this->flags);
            $this->placesAdd = self::getIds($this->places);
            $this->headEmployees = self::getIds($this->getEmployeesExpByType(Employee::HOLDEVENT)->all());
            $this->responsibleEmployees= self::getIds($this->getEmployeesExpByType(Employee::RESPONSIBLE)->all());
            $this->invitedEmployees= self::getIds($this->getEmployeesExpByType(Employee::INVITED)->all());
        }
    }

    public static function getIds($arValues)
    {
        return ArrayHelper::map($arValues, 'id', 'id');
    }

    public function beforeValidate()
    {
        if(!parent::beforeValidate())
            return false;
        if(in_array($this->scenario, [self::MONTH, self::WEEK])){
            $this->dateStart = Yii::$app->formatter->format($this->dateStart, ["date", "php:Y-m-d H:i:s"]);
            $this->dateStop = Yii::$app->formatter->format($this->dateStop, ["date", "php:Y-m-d H:i:s"]);
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionEmployees()
    {
        return $this->hasMany(ActionEmployee::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllEmployeesExp()
    {
        return $this->hasMany(Experience::className(), ['id' => 'exp_id'])->viaTable('action_employee', ['action_id' => 'id']);
    }

    /**
     * @param integer $type
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesExpByType($type)
    {
        return $this->getAllEmployeesExp()->leftJoin('action_employee', '{{%experience}}.id=action_employee.exp_id')->andWhere(['action_employee.type' => $type]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getActionFlags()
    {
        return $this->hasMany(ActionFlag::className(), ['action_id' => 'id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlags()
    {
        return $this->hasMany(Flag::className(), ['id' => 'flag_id'])->viaTable('action_flag', ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getActionPlaces()
    {
        return $this->hasMany(ActionPlace::className(), ['action_id' => 'id']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::className(), ['id' => 'place_id'])->viaTable('action_place', ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionFiles()
    {
        return $this->hasMany(ActionFile::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransfers()
    {
        return $this->hasMany(Transfer::className(), ['action_id' => 'id']);
    }

    public function getType()
    {
        if($this->isMonth()) return self::MONTH;
        if($this->isWeek()) return self::WEEK;
    }

    public function isWeek() {
        return $this->week;
    }

    public function isMonth() {
        return $this->month && !$this->week;
    }

    public function saveAllFields() {
        if(!$this->isNewRecord){
            ActionEmployee::deleteAll(['action_id' => $this->id]);
            Yii::$app->db->createCommand()->delete('action_flag', ['action_id' => $this->id])->execute();
            Yii::$app->db->createCommand()->delete('action_place', ['action_id' => $this->id])->execute();
        }
        if(!empty($this->flagsAdd)){
            $this->saveRelated('action_flag', 'flag_id',  $this->flagsAdd);
        }
        $this->saveRelated('action_place', 'place_id', $this->placesAdd);
        $this->saveRelated('action_employee', 'exp_id', $this->headEmployees, ['type' => Employee::HOLDEVENT]);
        $this->saveRelated('action_employee', 'exp_id', $this->responsibleEmployees, ['type' => Employee::RESPONSIBLE]);
        $this->saveRelated('action_employee', 'exp_id', $this->invitedEmployees, ['type' => Employee::INVITED]);
    }

    private function saveRelated($table, $column, $data, $externalColumns = []){
        $rows = array_map(function($el) use($externalColumns){
            return ArrayHelper::merge([$this->id, $el], array_values($externalColumns));
        }, $data);
        Yii::$app->db->createCommand()->batchInsert(
            $table,
            ArrayHelper::merge(['action_id', $column], array_keys($externalColumns)),
            $rows
        )->execute();
    }

    public function initDates()
    {
        $this->dateStart = date('d.m.Y H:i', (time() - (time() % 300)));
        $this->dateStop = date('d.m.Y H:i', strtotime($this->dateStart.' +30 minutes'));
    }
}
