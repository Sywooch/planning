<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_133049_add_transfer_table extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_converted_parent', '{{%action}}');
        $this->dropForeignKey('fk_transferred_parent', '{{%action}}');
        $this->dropColumn('{{%action}}', 'converted');
        $this->dropColumn('{{%action}}', 'converted_from');
        $this->dropColumn('{{%action}}', 'transferred');
        $this->dropColumn('{{%action}}', 'transferred_from');
        $this->dropColumn('{{%action}}', 'type');
        $this->dropColumn('{{%action}}', 'note');
        $this->renameColumn('{{%action}}', 'status', 'week_status');
        $this->addColumn('{{%action}}', 'month_status', Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0');
        $this->addColumn('{{%action}}', 'month', Schema::TYPE_BOOLEAN.' DEFAULT NULL');
        $this->addColumn('{{%action}}', 'week', Schema::TYPE_BOOLEAN.' DEFAULT NULL');

        $this->createTable('{{%transfer}}', [
            'number' => Schema::TYPE_SMALLINT.' NOT NULL',
            'action_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'old_start' => Schema::TYPE_DATETIME.' DEFAULT NULL',
            'old_stop' => Schema::TYPE_DATETIME.' DEFAULT NULL',
            'old_place' => 'VARCHAR(100) DEFAULT NULL',
            'note' => Schema::TYPE_TEXT.' DEFAULT NULL',
            'PRIMARY KEY(`number`, `action_id`)'
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_transfer_action', '{{%transfer}}', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->createIndex('ix_transfer_action', '{{%transfer}}', ['number', 'action_id'], true);
        $this->addForeignKey('fk_action_flag_flag', 'action_flag', 'flag_id', '{{%flag}}', 'id', 'CASCADE');
        $this->dropColumn('action_employee', 'weight');
        $this->renameColumn('action_employee', 'employee_type', 'type');
        $this->renameColumn('action_employee', 'agreement_status', 'week_approved');
        $this->addColumn('action_employee', 'month_approved', Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0');
        $this->renameColumn('action_employee', 'agreement_note', 'week_note');
        $this->addColumn('action_employee', 'month_note', Schema::TYPE_STRING.' DEFAULT NULL');
        $this->createIndex('ix_action_employee', 'action_employee', ['action_id', 'exp_id'], true);

        $this->addColumn('{{%action}}', 'template', 'TINYINT UNSIGNED NOT NULL DEFAULT 0');
        $this->addColumn('{{%action}}', 'repeat', Schema::TYPE_STRING);

        $this->dropTable('template_place');
        $this->dropTable('template_flag');
        $this->dropTable('template_employee');
        $this->dropTable('{{%template}}');

        $this->dropTable('{{%message}}');

        $this->renameTable('{{%mail_list}}', '{{%employee_list}}');
        $this->createIndex('ix_list_user', '{{%employee_list}}', ['id', 'user_id'], true);
        $this->renameTable('mail_list_employee', 'employee_list_employee');
        $this->createIndex('ix_employee_list_employee', 'employee_list_employee', ['list_id', 'employee_id'], true);
    }

    public function down()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->dropIndex('ix_list_user', '{{%employee_list}}');
        $this->renameTable('{{%employee_list}}', '{{%mail_list}}');
        $this->dropIndex('ix_employee_list_employee', 'employee_list_employee');
        $this->renameTable('employee_list_employee', 'mail_list_employee');
        $this->createTable('{{%message}}', [
            'id' => Schema::TYPE_PK,
            'sender_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'addressee_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'message' => Schema::TYPE_TEXT.' NOT NULL',
            'read' => Schema::TYPE_BOOLEAN.' DEFAULT 0',
            'created_at' => Schema::TYPE_TIMESTAMP.' NOT NULL',
        ],  $tableOptions);
        $this->addForeignKey('fk_message_sender','{{%message}}','sender_id','{{%user}}','id','CASCADE');
        $this->addForeignKey('fk_message_addressee','{{%message}}','addressee_id','{{%user}}','id','CASCADE');

        $this->createTable('{{%template}}', [
            'id'=>Schema::TYPE_PK,
            'start'=>Schema::TYPE_TIMESTAMP.' NOT NULL',
            'stop'=>Schema::TYPE_TIMESTAMP.' NOT NULL',
            'action'=>Schema::TYPE_TEXT.' NOT NULL',
            'repeat'=>Schema::TYPE_STRING,
            'category_id'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'user_id'=>Schema::TYPE_INTEGER.' NOT NULL'
        ], $tableOptions);
        $this->addForeignKey('fk_template_category', '{{%template}}', 'category_id', '{{%category}}', 'id', 'SET NULL');
        $this->addForeignKey('fk_template_user', '{{%template}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        $this->createTable('template_employee', [
            'template_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'employee_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`template_id`, `employee_id`)',
        ], $tableOptions);
        $this->addForeignKey('fk_te_template', 'template_employee', 'template_id', '{{%template}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_te_employee', 'template_employee', 'employee_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('template_flag', [
            'template_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'flag_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`template_id`, `flag_id`)',
        ], $tableOptions);
        $this->addForeignKey('fk_tf_template', 'template_flag', 'template_id', '{{%template}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_tf_flag', 'template_flag', 'flag_id', '{{%flag}}', 'id', 'CASCADE');

        $this->createTable('template_place', [
            'template_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'place_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`template_id`, `place_id`)',
        ], $tableOptions);
        $this->addForeignKey('fk_tp_template', 'template_place', 'template_id', '{{%template}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_tp_place', 'template_place', 'place_id', '{{%place}}', 'id', 'CASCADE');

        $this->dropColumn('{{%action}}', 'template');
        $this->dropColumn('{{%action}}', 'repeat');

        $this->dropIndex('ix_action_employee', 'action_employee');
        $this->dropColumn('action_employee', 'month_note');
        $this->renameColumn('action_employee', 'week_note', 'agreement_note');
        $this->dropColumn('action_employee', 'month_approved');
        $this->renameColumn('action_employee', 'week_approved', 'agreement_status');
        $this->renameColumn('action_employee', 'type', 'employee_type');
        $this->addColumn('action_employee', 'weight', Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0');
        $this->dropForeignKey('fk_action_flag_flag', 'action_flag');
        $this->dropIndex('ix_transfer_action', '{{%transfer}}');
        $this->dropForeignKey('fk_transfer_action', '{{%transfer}}');
        $this->dropTable('{{%transfer}}');
        $this->renameColumn('{{%action}}', 'week_status', 'status');
        $this->dropColumn('{{%action}}', 'month_status');
        $this->dropColumn('{{%action}}', 'month');
        $this->dropColumn('{{%action}}', 'week');
        $this->addColumn('{{%action}}', 'converted', Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0');
        $this->addColumn('{{%action}}', 'converted_from', Schema::TYPE_INTEGER);
        $this->addColumn('{{%action}}', 'transferred', Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0');
        $this->addColumn('{{%action}}', 'transferred_from', Schema::TYPE_INTEGER);
        $this->addColumn('{{%action}}', 'type', Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 2');
        $this->addColumn('{{%action}}', 'note', Schema::TYPE_STRING);
        $this->addForeignKey('fk_converted_parent', '{{%action}}', 'converted_from', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_transferred_parent', '{{%action}}','transferred_from','{{%action}}','id','CASCADE');
    }
}
