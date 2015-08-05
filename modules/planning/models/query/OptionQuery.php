<?php

namespace app\modules\planning\models\query;

use yii\db\ActiveQuery;

class OptionQuery extends ActiveQuery
{
    public function byId($id)
    {
        return $this->where(['id' => $id])->one();
    }
}