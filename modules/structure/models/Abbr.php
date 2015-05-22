<?php

namespace app\modules\structure\models;

use Yii;

/**
 * This is the model class for table "{{%abbr}}".
 *
 * @property string $abbr
 */
class Abbr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%abbr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['abbr'], 'required'],
            [['abbr'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'abbr' => Yii::t('structure', 'Abbr'),
        ];
    }
}
