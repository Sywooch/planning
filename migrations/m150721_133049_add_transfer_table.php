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
    }

    public function down()
    {
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
