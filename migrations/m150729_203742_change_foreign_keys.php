<?php

use yii\db\Schema;
use yii\db\Migration;

class m150729_203742_change_foreign_keys extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_af_action', 'action_flag');
        $this->dropForeignKey('fk_af_flags', 'action_flag');
        $this->addForeignKey('fk_af_action', 'action_flag', 'action_id', '{{%action}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_af_flags', 'action_flag', 'flag_id', '{{%flag}}', 'id', 'CASCADE', 'RESTRICT');
        $this->dropForeignKey('fk_ap_action', 'action_place');
        $this->dropForeignKey('fk_ap_place', 'action_place');
        $this->addForeignKey('fk_ap_action', 'action_place', 'action_id', '{{%action}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_ap_place', 'action_place', 'place_id', '{{%place}}', 'id', 'CASCADE', 'RESTRICT');

        $this->dropForeignKey('fk_experience', 'action_employee');
        $this->dropForeignKey('fk_action', 'action_employee');
        $this->addForeignKey('fk_experience', 'action_employee', 'exp_id', '{{%experience}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_action', 'action_employee', 'action_id', '{{%action}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk_experience', 'action_employee');
        $this->dropForeignKey('fk_action', 'action_employee');
        $this->addForeignKey('fk_experience', 'action_employee', 'exp_id', '{{%experience}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_action', 'action_employee', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->dropForeignKey('fk_ap_action', 'action_place');
        $this->dropForeignKey('fk_ap_place', 'action_place');
        $this->addForeignKey('fk_ap_action', 'action_place', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_ap_place', 'action_place', 'place_id', '{{%place}}', 'id', 'CASCADE');
        $this->dropForeignKey('fk_af_action', 'action_flag');
        $this->dropForeignKey('fk_af_flags', 'action_flag');
        $this->addForeignKey('fk_af_action', 'action_flag', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_af_flags', 'action_flag', 'flag_id', '{{%flag}}', 'id', 'CASCADE');
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
