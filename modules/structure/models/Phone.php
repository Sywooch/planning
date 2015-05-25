<?php

namespace app\modules\structure\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%phone}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $employee_id
 * @property string $phone
 */
class Phone extends ActiveRecord
{
    const WORK = 1;
    const MOBILE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%phone}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'employee_id'], 'integer'],
            [['employee_id', 'phone', 'type'], 'required'],
            [],
            [['phone'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('structure', 'Type'),
            'employee_id' => Yii::t('structure', 'Employee'),
            'phone' => Yii::t('structure', 'Phone'),
        ];
    }


}
