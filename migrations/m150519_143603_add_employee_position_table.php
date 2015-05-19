<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_143603_add_employee_position_table extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_employee_position', '{{%employee}}');
        $this->createTable('employee_position', [
            'employee_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'position_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'start'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'stop'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_ep_employee', 'employee_position', 'employee_id', '{{%employee}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_ep_position', 'employee_position', 'position_id', '{{%position}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('employee_position');
        $this->addForeignKey('fk_employee_position', '{{%employee}}', 'position_id', '{{%position}}', 'id', 'SET NULL');
    }
}
