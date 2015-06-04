<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_173240_add_experience_staff_relation extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_experience_department', '{{%experience}}');
        $this->dropForeignKey('fk_experience_position', '{{%experience}}');
        $this->dropColumn('{{%experience}}', 'department_id');
        $this->dropColumn('{{%experience}}', 'position_id');
        $this->dropForeignKey('fk_staff_list_department', '{{%staff_list}}');
        $this->dropForeignKey('fk_staff_list_position', '{{%staff_list}}');
        $this->dropPrimaryKey('pk_staff_list', '{{%staff_list}}');
        $this->addColumn('{{%staff_list}}', 'id', Schema::TYPE_PK);
        $this->addForeignKey('fk_staff_list_department', '{{%staff_list}}', 'department_id', '{{%department}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_staff_list_position', '{{%staff_list}}', 'position_id', '{{%position}}', 'id', 'CASCADE');
        $this->createIndex('ix_staff_list', '{{%staff_list}}', ['department_id', 'position_id']);
        $this->dropForeignKey('fk_experience_employee', '{{%experience}}');
        $this->dropIndex('ix_experience', '{{%experience}}');
        $this->addForeignKey('fk_experience_employee', '{{%experience}}', 'employee_id', '{{%employee}}', 'id', 'CASCADE');
        $this->addColumn('{{%experience}}', 'staff_unit_id', Schema::TYPE_INTEGER.' NOT NULL');
        $this->createIndex('ix_experience', '{{%experience}}', ['employee_id', 'staff_unit_id']);
        $this->addForeignKey('fk_experience_staff_unit', '{{%experience}}', 'staff_unit_id', '{{%staff_list}}', 'id', 'CASCADE');
    }

    public function down()
    {
        echo "m150604_173240_add_experience_staff_relation cannot be reverted.\n";

        return false;
    }
}
