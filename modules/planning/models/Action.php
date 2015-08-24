<?php

namespace app\modules\planning\models;

use app\models\User;
use app\modules\planning\models\query\PlanningQuery;
use app\modules\planning\models\search\ActionSearch;
use app\modules\structure\models\Employee;
use app\modules\structure\models\Experience;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Query;
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
 * @property Option[] $options
 */

//@todo При обновлении мероприятия, надо сделать так, чтобы обновлялись только измененные поля, а не все (Себе на заметку)

class Action extends ActiveRecord
{
    const MONTH = 'month';
    const WEEK = 'week';
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
    public static function find()
    {
        return new PlanningQuery(get_called_class());
    }

    public function scenarios()
    {
        return ArrayHelper::merge(
            [
                self::WEEK => ['action', 'dateStart', 'dateStop', 'flags', 'headEmployees', 'responsibleEmployees', 'invitedEmployees',  'places', 'user_id', 'options'],
                self::MONTH => ['action', 'dateStart', 'dateStop', 'flags', 'headEmployees', 'responsibleEmployees', 'invitedEmployees',  'places', 'user_id', 'options', 'category_id'],
            ],
            parent::scenarios()
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateStart', 'dateStop', 'action', 'headEmployees', 'responsibleEmployees', 'places'], 'required'],
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
            'category' => Yii::t('planning', 'Category'),
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
            'places' => Yii::t('planning', 'Places'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->dateStart = Yii::$app->formatter->format($this->dateStart, ['date', 'php:d.m.Y H:i']);
        $this->dateStop = Yii::$app->formatter->format($this->dateStop, ['date', 'php:d.m.Y H:i']);
        $filteredExp = $this->getAllEmployeesExp();
        $this->headEmployees = $filteredExp[Employee::HOLDEVENT];
        $this->responsibleEmployees= $filteredExp[Employee::RESPONSIBLE];
        $this->invitedEmployees= $filteredExp[Employee::INVITED];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if(!parent::beforeValidate())
            return false;
        if($this->scenario != ActionSearch::SEARCH){
            $this->dateStart = Yii::$app->formatter->format($this->dateStart, ["date", "php:Y-m-d H:i:s"]);
            $this->dateStop = Yii::$app->formatter->format($this->dateStop, ["date", "php:Y-m-d H:i:s"]);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        /**
         * Добавляем связь мероприятия с опцией только в том случае,
         * если опция не была добавлена на основе триггера add_flag_with_option
         */
        $this->saveAllRelatedFields();
        $existedId = array_map(
            function($el){return $el['option_id'];},
            (new Query())->select('option_id')->from('action_option')->where(['action_id' => $this->id])->all()
        );
        foreach($this->options as $option){
            if(!in_array($option->id, $existedId)){
                $this->link('options', $option);
            }
        }
        parent::AfterSave($insert, $changedAttributes);
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
        $expIds = (new Query)->select(['{{%experience}}.id', 'type', 'fio'])
            ->from('{{%experience}}')
            ->leftJoin('action_employee', '{{%experience}}.id = action_employee.exp_id')
            ->leftJoin('{{%action}}', 'action_employee.action_id = {{%action}}.id')
            ->leftJoin('{{%employee}}', '{{%experience}}.employee_id = {{%employee}}.id')
            ->where(['{{%action}}.id' => $this->id])
            ->all();
        foreach($expIds as $expId){
            $filteredArray[$expId['type']][] = $expId['id'];
        }
        return (isset($filteredArray))?$filteredArray:[];
    }

    /**
     * @param integer $type
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesExpByType($type)
    {
        return $this->hasMany(Experience::className(), ['id' => 'exp_id'])->viaTable('action_employee', ['action_id' => 'id'])->leftJoin('action_employee', '{{%experience}}.id=action_employee.exp_id')->andWhere(['action_employee.type' => $type]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlags()
    {
        return $this->hasMany(Flag::className(), ['id' => 'flag_id'])->viaTable('action_flag', ['action_id' => 'id']);
    }

    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::className(), ['id' => 'place_id'])->viaTable('action_place', ['action_id' => 'id']);
    }

    public function setPlaces($places)
    {
        $this->places = $places;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])->viaTable('action_option', ['action_id' => 'id']);
    }

    public function setOptions($options)
    {
        $this->options = (!empty($options))?array_map(function($opId){return Option::find()->byId($opId);}, $options):[];
    }

    /**
     * @return string
     */
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

    public function saveAllRelatedFields() {
        if(!$this->isNewRecord){
            ActionEmployee::deleteAll(['action_id' => $this->id]);
            $this->clearRelatedTable('action_flag');
            $this->clearRelatedTable('action_place');
            $this->clearRelatedTable('action_option');
        }
        if(!empty($this->flags)){
            $this->saveRelated('action_flag', 'flag_id',  $this->flags);
        }
        $this->saveRelated('action_place', 'place_id', $this->places);
        $this->saveRelated('action_employee', 'exp_id', $this->headEmployees, ['type' => Employee::HOLDEVENT]);
        $this->saveRelated('action_employee', 'exp_id', $this->responsibleEmployees, ['type' => Employee::RESPONSIBLE]);
        $this->saveRelated('action_employee', 'exp_id', $this->invitedEmployees, ['type' => Employee::INVITED]);
    }

    private function saveRelated($table, $column, $data, $externalColumns = []){
        $rows = array_map(function($el) use($externalColumns){
            return ArrayHelper::merge([$this->id, $el], array_values($externalColumns));
        }, $data);
        if(!empty($rows)){
            Yii::$app->db->createCommand()->batchInsert(
                $table,
                ArrayHelper::merge(['action_id', $column], array_keys($externalColumns)),
                $rows
            )->execute();
        }
    }

    public function initDates()
    {
        $this->dateStart = date('d.m.Y H:i', (time() - (time() % 300)));
        $this->dateStop = date('d.m.Y H:i', strtotime($this->dateStart.' +30 minutes'));
    }

    public function clearRelatedTable($tableName)
    {
        Yii::$app->db->createCommand()->delete($tableName, ['action_id' => $this->id])->execute();
    }

    public function newTransfer()
    {
        $transfer = new Transfer();
        $transfer->old_start = Yii::$app->formatter->asDatetime($this->dateStart, 'php:Y-m-d H:i:s');
        $transfer->old_stop = Yii::$app->formatter->asDatetime($this->dateStop, 'php:Y-m-d H:i:s');
        $transfer->old_place = implode('|', $this->places);
        $transfer->number = count($this->transfers) + 1;
        if(($note = Yii::$app->request->post('note'))!== null)
            $transfer->note = $note;
        return $transfer;
    }

    /**
     * @param Transfer $transfer
     */
    public function restoreTransfer($transfer)
    {
        $this->dateStart = $transfer->old_start;
        $this->dateStop = $transfer->old_stop;
        $this->places = $transfer->getPlacesId();
    }

    public function deleteTransfer($number)
    {
        Yii::$app->db->createCommand()
            ->delete(
                '{{%transfer}}',
                'number >= :number AND action_id = :id',
                [':number' => $number, ':id' => $this->id]
            )->execute();
    }
}
