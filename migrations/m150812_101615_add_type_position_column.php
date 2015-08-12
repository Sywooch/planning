<?php

use yii\db\Schema;
use yii\db\Migration;

class m150812_101615_add_type_position_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%position}}', 'municipal', $this->boolean()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%position}}', 'municipal');
    }
}
