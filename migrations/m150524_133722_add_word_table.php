<?php

use yii\db\Schema;
use yii\db\Migration;

class m150524_133722_add_word_table extends Migration
{
    public function up()
    {
        $this->dropTable('{{%abbr}}');
        $this->dropTable('{{%exclusion}}');
        $this->dropTable('{{%capital_word}}');
        $this->createTable('{{%word}}', [
            'word'=>Schema::TYPE_STRING.' NOT NULL',
            'type' => Schema::TYPE_SMALLINT.' NOT NULL',
            'PRIMARY KEY (`word`)',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m150524_133722_add_word_table cannot be reverted.\n";

        return false;
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
