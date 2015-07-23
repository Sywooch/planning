<?php

namespace app\modules\planning\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $action_id
 * @property string $controller_action
 * @property string $date
 *
 * @property Action $action
 * @property User $user
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action_id', 'controller_action'], 'required'],
            [['user_id', 'action_id'], 'integer'],
            [['date'], 'safe'],
            [['controller_action'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('planning', 'ID'),
            'user_id' => Yii::t('planning', 'User ID'),
            'action_id' => Yii::t('planning', 'Action ID'),
            'controller_action' => Yii::t('planning', 'Controller Action'),
            'date' => Yii::t('planning', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
