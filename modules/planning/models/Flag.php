<?php

namespace app\modules\planning\models;

use kartik\helpers\Html;
use kartik\icons\Icon;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "{{%flag}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $icon
 *
 * @property Action[] $actions
 * @property Option[] $options
 */
class Flag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'icon'], 'required'],
            [['name', 'description', 'icon'], 'string', 'max' => 255],
            [['options'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'icon' => Yii::t('planning', 'Icon'),
            'options' => Yii::t('planning', 'Options')
        ];
    }

    public function getIcon()
    {
        return Icon::showStack ($this->icon,'circle',['class'=>'fa-lg blue-icon'],['class'=>'fa-inverse']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(Action::className(),['id' => 'action_id'])->viaTable('action_flag', ['flag_id' => 'id']);
    }

    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])->viaTable('flag_option', ['flag_id' => 'id']);
    }

    public function setOptions($val)
    {
        $this->options = (!empty($val))?array_map(function($opId){return Option::find()->byId($opId);},$val):[];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->saveOptions();
        parent::afterSave($insert, $changedAttributes);
    }

    public function saveOptions()
    {
        Yii::$app->db->createCommand()->delete('flag_option', ['flag_id' => $this->id])->execute();
        foreach($this->options as $option){
            $this->link('options', $option);
        }
    }
}
