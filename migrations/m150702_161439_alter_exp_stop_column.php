<?php

use yii\db\Schema;
use yii\db\Migration;

class m150702_161439_alter_exp_stop_column extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%experience}}', 'start', Schema::TYPE_DATETIME.' NOT NULL');
        $this->alterColumn('{{%experience}}', 'stop', Schema::TYPE_DATETIME.' DEFAULT NULL');
    }

    public function down()
    {
        echo "m150702_161439_alter_exp_stop_column cannot be reverted.\n";
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
