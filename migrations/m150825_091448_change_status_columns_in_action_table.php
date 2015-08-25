<?php

use yii\db\Migration;

class m150825_091448_change_status_columns_in_action_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%action}}', 'month_status');
        $this->renameColumn('{{%action}}', 'week_status', 'status');
        $this->alterColumn('{{%action}}','status', $this->smallInteger()->notNull());
    }

    public function down()
    {
        $this->renameColumn('{{%action}}', 'status', 'week_status');
        $this->addColumn('{{%action}}', 'month_status', $this->smallInteger()->notNull());
    }
}
