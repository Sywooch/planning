<?php

namespace app\modules\planning\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\planning\models\Action;

class ActionSearch extends Action
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['dateStart', 'dateStop', 'action'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Action::scenarios();
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

        $query->andFilterWhere(['category_id' => $this->category_id]);

        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', "DATE_FORMAT(dateStart,'%d.%m.%Y')", $this->dateStart])
            ->andFilterWhere(['like', "DATE_FORMAT(dateStop,'%d.%m.%Y')", $this->dateStop]);

        return $dataProvider;
    }
}