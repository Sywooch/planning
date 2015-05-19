<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_094604_init_database extends Migration
{
    public function up()
    {
         $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
             $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->execute('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0');
        $this->execute('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0');
        $this->execute('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO"');

        $this->createTable('{{%place}}',[
            'id' => Schema::TYPE_PK,
            'place' => Schema::TYPE_STRING.' NOT NULL'
        ], $tableOptions);

        $this->createTable('{{%department}}', array(
            'id' => Schema::TYPE_PK,
            'department' => Schema::TYPE_STRING.' NOT NULL',
            'department_id' => Schema::TYPE_INTEGER.' DEFAULT NULL'
        ), $tableOptions);
        $this->addForeignKey('fk_childdep_dep','{{%department}}', 'department_id', '{{%department}}', 'id', 'CASCADE');

        $this->createTable('{{%position}}', [
            'id'=>Schema::TYPE_PK,
            'position'=> Schema::TYPE_STRING.' NOT NULL'
        ], $tableOptions);

        $this->createTable('{{%employee}}', [
            'id' => Schema::TYPE_PK,
            'fio' => Schema::TYPE_STRING.' NOT NULL',
            'position_id' => Schema::TYPE_INTEGER.' DEFAULT NULL',
            'useGenitive' => Schema::TYPE_BOOLEAN.' NOT NULL',
            'chief' => Schema::TYPE_BOOLEAN.' DEFAULT 0',
            'email' => 'VARCHAR(128)',
            'department_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'logic_delete' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'weight' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ], $tableOptions);
        $this->addForeignKey('fk_employee_department', '{{%employee}}', 'department_id', '{{%department}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_employee_position', '{{%employee}}', 'position_id', '{{%position}}', 'id', 'SET NULL');

        $this->createTable('{{%phone}}', [
          'id'=>Schema::TYPE_PK,
          'type'=>Schema::TYPE_SMALLINT . ' DEFAULT 0',
          'employee_id' => Schema::TYPE_INTEGER.' NOT NULL',
          'phone'=> 'VARCHAR(10) NOT NULL'
        ], $tableOptions);
        $this->addForeignKey('fk_phone_employee', '{{%phone}}', 'employee_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32)',
            'password_hash' => Schema::TYPE_STRING,
            'password_reset_token' => Schema::TYPE_STRING,
            'employee_id'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'ldap'=>Schema::TYPE_BOOLEAN.' DEFAULT 0',
        ], $tableOptions);
        $this->addForeignKey('fk_user_employee', '{{%user}}', 'employee_id', '{{%employee}}', 'id', 'SET NULL');

        $this->createTable('{{%io_calendar}}', [
          'id' => Schema::TYPE_PK,
          'emp_id' => Schema::TYPE_INTEGER.' NOT NULL',
          'chief_id' => Schema::TYPE_INTEGER.' NOT NULL',
          'start' => Schema::TYPE_INTEGER.' NOT NULL',
          'stop' => Schema::TYPE_INTEGER.' NOT NULL'
        ], $tableOptions);
        $this->addForeignKey('fk_io_calendar_employee', '{{%io_calendar}}', 'emp_id', '{{%employee}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_io_calendar_chiefEmployee', '{{%io_calendar}}', 'chief_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('{{%category}}', [
            'id'=>Schema::TYPE_PK,
            'name'=>Schema::TYPE_STRING.' NOT NULL',
            'weight'=>Schema::TYPE_INTEGER.' UNSIGNED DEFAULT 1000'
        ], $tableOptions);

        $this->createTable('{{%action}}', [
            'id' => Schema::TYPE_PK,
            'dateStart' => Schema::TYPE_DATETIME.' NOT NULL',
            'dateStop' => Schema::TYPE_DATETIME.' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER,
            'action' => Schema::TYPE_TEXT.' NOT NULL',
            'type'=> Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 2',
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'status' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
            'confirmed' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'converted' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'converted_from' => Schema::TYPE_INTEGER,
            'transferred' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'transferred_from' => Schema::TYPE_INTEGER,
            'note' => Schema::TYPE_STRING,
        ], $tableOptions);
        $this->addForeignKey('fk_action_author', '{{%action}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_converted_parent', '{{%action}}', 'converted_from', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_action_category','{{%action}}','category_id','{{%category}}','id','SET NULL');
        $this->addForeignKey('fk_transferred_parent', '{{%action}}','transferred_from','{{%action}}','id','CASCADE');

        $this->createTable('action_place', [
            'action_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'place_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`action_id`, `place_id`)'
        ], $tableOptions);
        $this->addForeignKey('fk_ap_action', 'action_place', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_ap_place', 'action_place', 'place_id', '{{%place}}', 'id', 'CASCADE');

        $this->createTable('action_employee', [
            'action_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'employee_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'employee_type' => Schema::TYPE_SMALLINT.' NOT NULL',
            'visited' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'agreement_status' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'agreement_note' => Schema::TYPE_STRING,
            'weight' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
            'PRIMARY KEY (`action_id`, `employee_id`)'
        ], $tableOptions);
        $this->addForeignKey('fk_action', 'action_employee', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_employee', 'action_employee', 'employee_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('{{%flag}}', array(
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING.' NOT NULL',
            'description' => Schema::TYPE_STRING.' NOT NULL',
            'icon' => Schema::TYPE_STRING.' NOT NULL'
        ), $tableOptions);

        $this->createTable('action_flag', array(
            'action_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'flag_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`action_id`,`flag_id`)'
        ), $tableOptions);
        $this->addForeignKey('fk_af_action', 'action_flag', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_af_flags', 'action_flag', 'flag_id', '{{%flags}}', 'id', 'CASCADE');

        $this->createTable('{{%log}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'action_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'controller_action' => Schema::TYPE_STRING.' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP.' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('fk_log_user','{{%log}}','user_id','{{%user}}','id','CASCADE');
        $this->addForeignKey('fk_log_action', '{{%log}}', 'action_id', '{{%action}}', 'id', 'CASCADE');

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

        $this->createTable('{{%action_file}}', [
            'id'=>Schema::TYPE_PK,
            'action_id'=> Schema::TYPE_INTEGER.' NOT NULL',
            'filename'=>Schema::TYPE_STRING.' NOT NULL',
            'file_url'=>Schema::TYPE_STRING.' NOT NULL'
        ], $tableOptions);
        $this->addForeignKey('fk_file_action','{{%action_file}}','action_id','{{%action}}','id','CASCADE');

        $this->createTable('{{%mail_list}}', [
          'id'=>Schema::TYPE_PK,
          'user_id'=>Schema::TYPE_INTEGER,
          'list_name'=> Schema::TYPE_STRING.' NOT NULL',
          'public_list'=>Schema::TYPE_BOOLEAN.' DEFAULT 0',
        ], $tableOptions);
        $this->addForeignKey('fk_list_user','{{%mail_list}}','user_id','{{%user}}','id','SET NULL');

        $this->createTable('mail_list_employee', [
          'list_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'employee_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'PRIMARY KEY (`list_id`, `employee_id`)',
        ], $tableOptions);
        $this->addForeignKey('fk_list_employee','mail_list_employee','list_id', '{{%mail_list}}', 'id','CASCADE');
        $this->addForeignKey('fk_employee_list','mail_list_employee','employee_id','{{%employee}}','id','CASCADE');

        $this->createTable('{{%report}}', [
            'id'=>Schema::TYPE_PK,
            'created_at'=>Schema::TYPE_TIMESTAMP.' NOT NULL',
            'department_id'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'type'=>Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 2',
            'report_file'=>Schema::TYPE_STRING.' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('fk_report_department','{{%report}}','department_id','{{%department}}','id','SET NULL');

        $this->execute('INSERT INTO items VALUES ("deputy",2,"Заместители, которые проверяют проекты планов","","s:0:\"\";"),
                      ("CheckPlanProject",1,"Проверка проектов планов мероприятий","","s:0:\"\";");');
        $this->execute('INSERT INTO itemchildren VALUES ("deputy","CheckPlanProject"),("admin","CheckPlanProject");');

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

        $this->execute('SET SQL_MODE=@OLD_SQL_MODE;');
        $this->execute('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;');
        $this->execute('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;');
    }

    public function down()
    {
        $this->execute('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0');
        $this->execute('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0');
        $this->execute('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO"');
        $this->dropTable('template_place');
        $this->dropTable('template_flag');
        $this->dropTable('template_employee');
        $this->dropTable('{{%template}}');
        $this->dropTable('{{%report}}');
        $this->dropTable('mail_list_employee');
        $this->dropTable('{{%mail_list}}');
        $this->dropTable('{{%action_file}}');
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%log}}');
        $this->dropTable('assignments');
        $this->dropTable('itemchildren');
        $this->dropTable('items');
        $this->dropTable('action_place');
        $this->dropTable('{{%action}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%io_calendar}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%phone}}');
        $this->dropTable('{{%employee}}');
        $this->dropTable('{{%position}}');
        $this->dropTable('{{%department}}');
        $this->dropTable('{{%place}}');
        $this->dropTable('{{%flag}}');
        $this->dropTable('action_flag');
        $this->dropTable('action_employee');
        $this->execute('SET SQL_MODE=@OLD_SQL_MODE;');
        $this->execute('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;');
        $this->execute('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;');
    }
}
