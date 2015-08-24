<?php

namespace app\modules\planning\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\planning\models\Action;
use yii\helpers\ArrayHelper;

class ActionSearch extends Action
{
    const SEARCH = 'search';
    public $category;

    public function __construct()
    {
        $this->scenario = self::SEARCH;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateStart', 'dateStop', 'action'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            Action::scenarios(),
            [
                self::SEARCH => ['category', 'dateStart', 'dateStop', 'action']
            ]
        );
    }

    public function search($params)
    {
        $query = Action::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['category'] = [
            'asc' => ['{{%category}}.name' => SORT_ASC],
            'desc' => ['{{%category}}.name' => SORT_DESC],
        ];

        $query->joinWith('category');


        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', "DATE_FORMAT(dateStart,'%d.%m.%Y')", $this->dateStart])
            ->andFilterWhere(['like', "DATE_FORMAT(dateStop,'%d.%m.%Y')", $this->dateStop])
            ->andFilterWhere(['like', '{{%category}}.name', $this->category]);

        return $dataProvider;
    }
}