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

    public function __toString() {
        switch($this->type){
            case self::WORK:
                return preg_replace('/(\d{2})(\d{2})(\d{2})/', "$1-$2-$3", $this->phone);
                break;
            case self::MOBILE:
                return preg_replace('/(\d{3})(\d{3})(\d{2})(\d{2})/', "($1) $2-$3-$4", $this->phone);
                break;
            default:
                return $this->phone;
        }
    }

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

    private static function getIcons(){
        return [
            self::WORK => 'glyphicon glyphicon-earphone',
            self::MOBILE => 'glyphicon glyphicon-phone',
        ];
    }

    public static function getIcon($type){
        return self::getIcons()[$type];
    }

    private static function getTypes() {
        return [
            self::WORK => 'work',
            self::MOBILE => 'mobile',
        ];
    }

    public static function getType($type) {
        return self::getTypes()[$type];
    }

    public static function normalize($phone) {
        return preg_replace('/\(|\)|-/', '',$phone);
    }

    private static function getMasks() {
        return [
            self::WORK => '99-99-99',
            self::MOBILE => '(999) 999-99-99',
        ];
    }

    public static function getMask($type) {
        return self::getMasks()[$type];
    }
}
