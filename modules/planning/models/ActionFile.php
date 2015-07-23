<?php

namespace app\modules\planning\models;

use Yii;

/**
 * This is the model class for table "{{%action_file}}".
 *
 * @property integer $id
 * @property integer $action_id
 * @property string $filename
 * @property string $file_url
 *
 * @property Action $action
 */
class ActionFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_id', 'filename', 'file_url'], 'required'],
            [['action_id'], 'integer'],
            [['filename', 'file_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('planning', 'ID'),
            'action_id' => Yii::t('planning', 'Action ID'),
            'filename' => Yii::t('planning', 'Filename'),
            'file_url' => Yii::t('planning', 'File Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }
}
