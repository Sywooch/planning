<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_083545_structure_change extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->dropTable('employee_position');
        $this->dropForeignKey('fk_employee_department', '{{%employee}}');
        $this->dropColumn('{{%employee}}', 'department_id');
        $this->dropColumn('{{%employee}}', 'position_id');
        $this->dropColumn('{{%employee}}', 'chief');
        $this->dropColumn('{{%employee}}', 'weight');
        $this->addColumn('{{%position}}', 'chief', Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0');
        $this->addColumn('{{%position}}', 'weight', Schema::TYPE_INTEGER.' NOT NULL DEFAULT 1000');
        $this->createTable('{{%experience}}', [
            'id' => Schema::TYPE_PK,
            'employee_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'department_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'position_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'start' => Schema::TYPE_TIMESTAMP.' NOT NULL',
            'stop'=> Schema::TYPE_TIMESTAMP.' DEFAULT 0',
        ], $tableOptions);
        $this->createIndex('ix_experience', '{{%experience}}', ['employee_id', 'department_id', 'position_id']);
        $this->addForeignKey('fk_experience_employee', '{{%experience}}', 'employee_id', '{{%employee}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_experience_department', '{{%experience}}', 'department_id', '{{%department}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_experience_position', '{{%experience}}', 'position_id', '{{%position}}', 'id', 'CASCADE');


        $this->dropForeignKey('fk_io_calendar_employee', '{{%io_calendar}}');
        $this->dropForeignKey('fk_io_calendar_chiefEmployee', '{{%io_calendar}}');
        $this->addForeignKey('fk_io_calendar_chief', '{{%io_calendar}}', 'chief_id', '{{%experience}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_io_calendar_employee', '{{%io_calendar}}', 'emp_id', '{{%experience}}', 'id', 'CASCADE');

        $this->createTable('{{%staff_list}}', [
            'department_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'position_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'count' => Schema::TYPE_INTEGER.' DEFAULT 1',
        ], $tableOptions);
        $this->addPrimaryKey('pk_staff_list', '{{%staff_list}}', ['department_id', 'position_id']);
        $this->addForeignKey('fk_staff_list_department', '{{%staff_list}}', 'department_id', '{{%department}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_staff_list_position', '{{%staff_list}}', 'position_id', '{{%position}}', 'id', 'CASCADE');
    }

    public function down()
    {
        echo "m150527_083545_structure_change cannot be reverted.\n";

        return false;
    }
}
