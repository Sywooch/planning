<?php

namespace app\modules\planning\models;

use app\modules\planning\models\query\OptionQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%option}}".
 *
 * @property integer $id
 * @property string $option
 * @property string $duration
 *
 * @property Action[] $actions
 * @property Flag[] $flags
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%option}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option', 'duration'], 'required'],
            [['duration'], 'safe'],
            [['option'], 'string', 'max' => 255],
            [['option'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'option' => Yii::t('planning', 'Option'),
            'duration' => Yii::t('planning', 'Duration'),
        ];
    }

    public static function find()
    {
        return new OptionQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(Action::className(), ['id' => 'action_id'])->viaTable('action_option', ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlags()
    {
        return $this->hasMany(Flag::className(), ['id' => 'flag_id'])->viaTable('flag_option', ['option_id' => 'id']);
    }

    public static function configForSelect2()
    {
        return [
            'data' => ArrayHelper::map(Option::find()->all(), 'id', function(Option $el){ return $el->option.' ('.$el->duration.')';}),
            'options' => ['placeholder' => Yii::t('planning', 'Select a option ...'), 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ];
    }
}
