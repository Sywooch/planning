<?php

namespace app\modules\planning\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%transfer}}".
 *
 * @property integer $number
 * @property integer $action_id
 * @property string $old_start
 * @property string $old_stop
 * @property string $old_place
 * @property string $note
 *
 * @property Action $action
 */
class Transfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'action_id'], 'required'],
            [['number', 'action_id'], 'integer'],
            [['old_start', 'old_stop'], 'safe'],
            [['note'], 'string'],
            [['old_place'], 'string', 'max' => 100],
            [['number', 'action_id'], 'unique', 'targetAttribute' => ['number', 'action_id'], 'message' => 'The combination of Number and Action ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('planning', 'Number'),
            'action_id' => Yii::t('planning', 'Action ID'),
            'old_start' => Yii::t('planning', 'Previous start date'),
            'old_stop' => Yii::t('planning', 'Previous stop date'),
            'old_place' => Yii::t('planning', 'Previous places'),
            'note' => Yii::t('planning', 'Note'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    public function preparePlacesLinks()
    {
        foreach(explode('|', $this->old_place) as $placeInfo){
            list($id, $placeName) = explode('::', $placeInfo);
            $links[] = Html::a($placeName, ['/planning/place/view', 'id' => $id]);
        }
        return (isset($links))?implode(', ', $links):'';
    }

    public function getPlacesId()
    {
        foreach(explode('|', $this->old_place) as $placeInfo){
            list($id, $placeName) = explode('::', $placeInfo);
            $ids[] = $id;
        }
        return (isset($ids))?$ids:[];
    }
}
