<?php

namespace app\modules\planning\models;

use yii\db\ActiveQuery;

class ActionEmployeeQuery extends ActiveQuery
{
    /**
     * @param $type
     * @return ActiveQuery
     */
    public function getEmployeesByType($type)
    {
        return $this->andWhere(['type' => $type]);
    }
}