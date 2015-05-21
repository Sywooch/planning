<?php

namespace app\modules\structure\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property integer $id
 * @property string $fio
 * @property integer $position_id
 * @property integer $useGenitive
 * @property integer $chief
 * @property string $email
 * @property integer $department_id
 * @property integer $logic_delete
 * @property integer $weight
 * @property integer $created_at
 * @property integer $updated_at
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'useGenitive', 'department_id', 'position_id'], 'required'],
            [['position_id', 'useGenitive', 'chief', 'department_id', 'logic_delete', 'weight', 'created_at', 'updated_at'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fio' => Yii::t('structure', 'Fio'),
            'position_id' => Yii::t('structure', 'Position'),
            'useGenitive' => Yii::t('structure', 'Use Genitive'),
            'chief' => Yii::t('structure', 'Chief'),
            'email' => Yii::t('structure', 'Email'),
            'department_id' => Yii::t('structure', 'Department'),
            'logic_delete' => Yii::t('structure', 'Logic delete'),
            'weight' => Yii::t('app', 'Weight'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
