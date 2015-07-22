<?php

namespace app\modules\planning\models;

use app\models\User;
use app\modules\structure\models\Experience;
use Yii;
use yii\db\ActiveRecord;

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
 *
 * @property ActionEmployee[] $actionEmployees
 * @property Experience[] $exps
 * @property ActionFlag[] $actionFlags
 * @property Flags[] $flags
 * @property ActionPlace[] $actionPlaces
 * @property Place[] $places
 * @property User $author
 * @property Category $category
 * @property ActionFile[] $actionFiles
 * @property Log[] $logs
 * @property Transfer[] $transfers
 */
class Action extends ActiveRecord
{
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
            [['dateStart', 'dateStop', 'action', 'user_id', 'created_at', 'updated_at'], 'required'],
            [['dateStart', 'dateStop'], 'safe'],
            [['category_id', 'user_id', 'week_status', 'confirmed', 'created_at', 'updated_at', 'month_status', 'month', 'week', 'template'], 'integer'],
            [['action'], 'string'],
            [['repeat'], 'string', 'max' => 255]
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
            'action' => Yii::t('planning', 'Action'),
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
    public function getExps()
    {
        return $this->hasMany(Experience::className(), ['id' => 'exp_id'])->viaTable('action_employee', ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionFlags()
    {
        return $this->hasMany(ActionFlag::className(), ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlags()
    {
        return $this->hasMany(Flags::className(), ['id' => 'flag_id'])->viaTable('action_flag', ['action_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionPlaces()
    {
        return $this->hasMany(ActionPlace::className(), ['action_id' => 'id']);
    }

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
}
