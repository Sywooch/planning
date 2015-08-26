<?php

use yii\db\Migration;

class m150826_122039_add_allow_cross_action_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%action}}', 'allow_collision', $this->boolean()->defaultValue(0)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%action}}', 'allow_collision');
    }
}
