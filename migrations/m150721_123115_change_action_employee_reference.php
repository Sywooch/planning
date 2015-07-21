<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_123115_change_action_employee_reference extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_employee', 'action_employee');
        $this->renameColumn('action_employee', 'employee_id', 'exp_id');
        $this->alterColumn('action_employee', 'exp_id', Schema::TYPE_INTEGER.' NOT NULL');
        $this->addForeignKey('fk_experience', 'action_employee', 'exp_id', '{{%experience}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_experience', 'action_employee');
        $this->renameColumn('action_employee', 'exp_id', 'employee_id');
        $this->alterColumn('action_employee', 'employee_id', Schema::TYPE_INTEGER.' NOT NULL');
        $this->addForeignKey('fk_employee', 'action_employee', 'employee_id', '{{%employee}}', 'id', 'CASCADE');
    }
}
