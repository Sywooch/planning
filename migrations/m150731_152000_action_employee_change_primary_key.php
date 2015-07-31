<?php

use yii\db\Schema;
use yii\db\Migration;

class m150731_152000_action_employee_change_primary_key extends Migration
{
    public function up()
    {
        $this->dropIndex('ix_action_employee', 'action_employee');
        $this->execute('alter table action_employee DROP PRIMARY KEY , ADD PRIMARY KEY(action_id, exp_id, type)');
        $this->createIndex('ix_action_employee_type', 'action_employee', ['action_id', 'exp_id', 'type']);
    }

    public function down()
    {
        $this->dropIndex('ix_action_employee_type', 'action_employee');
        $this->execute('alter table action_employee DROP PRIMARY KEY , ADD PRIMARY KEY(action_id, exp_id)');
        $this->createIndex('ix_action_employee', 'action_employee', ['action_id', 'exp_id']);
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
