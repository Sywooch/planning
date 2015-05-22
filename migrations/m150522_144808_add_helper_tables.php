<?php

use yii\db\Schema;
use yii\db\Migration;

class m150522_144808_add_helper_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%abbr}}', [
            'abbr' => 'VARCHAR(20) NOT NULL',
            'PRIMARY KEY (`abbr`)'
        ], $tableOptions);
        $this->createTable('{{%capital_word}}', [
            'capital_word' => Schema::TYPE_STRING.' NOT NULL',
            'PRIMARY KEY (`capital_word`)'
        ], $tableOptions);
        $this->createTable('{{%exclusion}}', [
            'exclusion' => Schema::TYPE_STRING.' NOT NULL',
            'PRIMARY KEY (`exclusion`)'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%abbr}}');
        $this->dropTable('{{%capital_word}}');
        $this->dropTable('{{%exclusion}}');
    }
}
