<?php

namespace app\modules\planning\models;

use kartik\helpers\Html;
use kartik\icons\Icon;
use Yii;
use yii\db\ActiveRecord;

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
            [['name', 'description', 'icon'], 'string', 'max' => 255]
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
}
