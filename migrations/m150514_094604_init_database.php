<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_094604_init_database extends Migration
{
    public function up()
    {
        $this->execute('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0');
        $this->execute('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0');
        $this->execute('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO"');

        $this->createTable('{{%place}}',[
            'id' => 'pk',
            'place' => Schema::TYPE_STRING.' NOT NULL'
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{%department}}', array(
            'id' => 'pk',
            'department' => Schema::TYPE_TEXT.' NOT NULL',
            'department_id' => Schema::TYPE_INTEGER.' DEFAULT NULL'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_childdep_dep','{{%department}}', 'department_id', '{{%department}}', 'id', 'CASCADE');

        $this->createTable('{{%position}}', [
            'id'=>'pk',
            'position'=> Schema::TYPE_STRING.' NOT NULL'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{%employee}}', [
            'id' => 'pk',
            'fio' => Schema::TYPE_STRING.' NOT NULL',
            'position_id' => Schema::TYPE_INTEGER.' DEFAULT NULL',
            'useGenitive' => Schema::TYPE_BOOLEAN.' NOT NULL',
            'chief' => Schema::TYPE_BOOLEAN.' DEFAULT 0',
            'email' => 'VARCHAR(128)',
            'department_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'logic_delete' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0',
            'weight' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_employee_department', '{{%employee}}', 'department_id', '{{%department}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_employee_position', '{{%employee}}', 'position_id', '{{%position}}', 'id', 'SET NULL');

        $this->createTable('{{%phone}}', [
          'id'=>'pk',
          'type'=>Schema::TYPE_SMALLINT . ' DEFAULT 0',
          'employee_id' => Schema::TYPE_INTEGER.' NOT NULL',
          'phone'=> 'VARCHAR(10) NOT NULL'
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_phone_employee', '{{%phone}}', 'employee_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('{{%user}}', [
            'id'=>'pk',
            'name'=>Schema::TYPE_STRING.' NOT NULL',
            'password'=>'VARCHAR(34) NOT NULL',
            'employee_id'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'ldap'=>Schema::TYPE_BOOLEAN.' DEFAULT 0',
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_user_employee', '{{%user}}', 'employee_id', '{{%employee}}', 'id', 'SET NULL');

        $this->createTable('{{%io_calendar}}', [
          'id' => 'pk',
          'emp_id' => Schema::TYPE_INTEGER.' NOT NULL',
          'chief_id' => Schema::TYPE_INTEGER.' NOT NULL',
          'start' => Schema::TYPE_INTEGER.' NOT NULL',
          'stop' => Schema::TYPE_INTEGER.' NOT NULL'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_io_calendar_employee', '{{%io_calendar}}', 'emp_id', '{{%employee}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_io_calendar_chiefEmployee', '{{%io_calendar}}', 'chief_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('{{%category}}', [
            'id'=>'pk',
            'name'=>Schema::TYPE_STRING.' NOT NULL',
            'weight'=>Schema::TYPE_INTEGER.' UNSIGNED DEFAULT 1000'
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{%action}}', [
            'id' => 'pk',
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
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_action_author', '{{%action}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_converted_parent', '{{%action}}', 'converted_from', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_action_category','{{%action}}','category_id','{{%category}}','id','SET NULL');
        $this->addForeignKey('fk_transferred_parent', '{{%action}}','transferred_from','{{%action}}','id','CASCADE');

        $this->createTable('action_place', [
            'action_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'place_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`action_id`, `place_id`)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
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
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_action', 'action_employee', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_employee', 'action_employee', 'employee_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('{{%flag}}', array(
            'id' => 'pk',
            'name' => Schema::TYPE_STRING.' NOT NULL',
            'description' => Schema::TYPE_STRING.' NOT NULL',
            'icon' => Schema::TYPE_STRING.' NOT NULL'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('action_flag', array(
            'action_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'flag_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`action_id`,`flag_id`)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_af_action', 'action_flag', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_af_flags', 'action_flag', 'flag_id', '{{%flags}}', 'id', 'CASCADE');

        $this->createTable('items', [
            'name' => 'varchar(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER.' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'bizrule' => Schema::TYPE_TEXT,
            'data' => Schema::TYPE_TEXT,
            'PRIMARY KEY (`name`)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->execute('LOCK TABLES `items` WRITE;
      /*!40000 ALTER TABLE `items` DISABLE KEYS */;
      INSERT INTO `items` VALUES ("ActionAlwaysAdd",1,"Возможность обходить запреты по добавлению мероприятий","","s:0:\"\";"),
        ("ActionFullView",1,"Просмотр всех полей мероприятия","","s:0:\"\";"),
        ("ActionViewFooter",0,"Показывает автора мероприятия в подвале","","s:0:\"\";"),
        ("admin",2,NULL,NULL,NULL),("authorized",2,"Авторизованные пользователи","","s:0:\"\";"),
        ("chief",2,"Начальник отдела","","s:0:\"\";"),("chiefIo",2,"Исполняющий обязанности","","s:0:\"\";"),
        ("ChiefPermissions",1,"Права начальника отдела","","s:0:\"\";"),
        ("EmployeeAdministratig",1,"Администрирование записей о сотрудниках","","s:0:\"\";"),
        ("EmployeeCreate",0,"Добавление нового сотрудника","","s:0:\"\";"),
        ("EmployeeDelete",0,"Удаление информации о сотруднике","","s:0:\"\";"),
        ("EmployeeManage",0,"Управление записями о сотрудниках","","s:0:\"\";"),
        ("EmployeeUpdate",0,"Изменение информации о сотруднике","","s:0:\"\";"),
        ("ManageChiefAction",1,"Право на просмотр и изменение мероприятий, которые добавил начальник отдела","","s:0:\"\";"),
        ("setIo",0,"Назначить исполняющего обязанности начальника отдела","","s:0:\"\";"),
        ("UserAdministrating",1,"Управление и администрирование пользователями","","s:0:\"\";"),
        ("UserEdit",0,"Редактирование данных о пользователе","","s:0:\"\";"),
        ("UserEditEmployee",0,"Редактирование закрепленного за пользователем сотрудника","","s:0:\"\";"),
        ("UserView",0,"Просмотр личных данных пользователей","","s:0:\"\";");
      /*!40000 ALTER TABLE `items` ENABLE KEYS */;
    UNLOCK TABLES;');

        $this->createTable('itemchildren', [
          'parent' => 'VARCHAR(64) NOT NULL',
          'child' => 'VARCHAR(64) NOT NULL',
          'PRIMARY KEY (`parent`,`child`)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('itemchildren_ibfk_1', 'itemchildren', 'parent', 'items', 'name', 'CASCADE');
        $this->addForeignKey('itemchildren_ibfk_2', 'itemchildren', 'child', 'items', 'name', 'CASCADE');
        $this->execute('LOCK TABLES `itemchildren` WRITE;
      /*!40000 ALTER TABLE `itemchildren` DISABLE KEYS */;
      INSERT INTO `itemchildren` VALUES ("admin","ActionAlwaysAdd"),
        ("admin","ActionFullView"),
        ("ActionFullView","ActionViewFooter"),
        ("admin","ChiefPermissions"),
        ("chief","ChiefPermissions"),
        ("admin","EmployeeAdministratig"),
        ("EmployeeAdministratig","EmployeeCreate"),
        ("EmployeeAdministratig","EmployeeDelete"),
        ("EmployeeAdministratig","EmployeeManage"),
        ("EmployeeAdministratig","EmployeeUpdate"),
        ("chiefIo","ManageChiefAction"),
        ("ChiefPermissions","setIo"),
        ("admin","UserAdministrating"),
        ("UserAdministrating","UserEdit"),
        ("UserAdministrating","UserEditEmployee"),
        ("UserAdministrating","UserView");
      /*!40000 ALTER TABLE `itemchildren` ENABLE KEYS */;
    UNLOCK TABLES;');

        $this->createTable('assignments', [
            'itemname' => 'VARCHAR(64) NOT NULL',
            'userid' => 'VARCHAR(64) NOT NULL',
            'bizrule' => Schema::TYPE_TEXT,
            'data' => Schema::TYPE_TEXT,
            'PRIMARY KEY (`itemname`,`userid`)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('assignments_ibfk_1', 'assignments', 'itemname', 'items', 'name', 'CASCADE');
        $this->execute('LOCK TABLES `assignments` WRITE;
        /*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
        INSERT INTO `assignments` VALUES ("admin","1","","s:0:\"\";");
        /*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
        UNLOCK TABLES;');

        $this->createTable('{{%log}}', [
            'id' => 'pk',
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'action_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'controller_action' => Schema::TYPE_STRING.' NOT NULL',
            'date' => Schema::TYPE_TIMESTAMP.' NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_log_user','{{%log}}','user_id','{{%user}}','id','CASCADE');
        $this->addForeignKey('fk_log_action', '{{%log}}', 'action_id', '{{%action}}', 'id', 'CASCADE');

        $this->createTable('{{%message}}', [
            'id' => 'pk',
            'sender_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'addressee_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'message' => Schema::TYPE_TEXT.' NOT NULL',
            'read' => Schema::TYPE_BOOLEAN.' DEFAULT 0',
            'created_at' => Schema::TYPE_TIMESTAMP.' NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_message_sender','{{%message}}','sender_id','{{%user}}','id','CASCADE');
        $this->addForeignKey('fk_message_addressee','{{%message}}','addressee_id','{{%user}}','id','CASCADE');

        $this->createTable('{{%action_file}}', [
            'id'=>'pk',
            'action_id'=> Schema::TYPE_INTEGER.' NOT NULL',
            'filename'=>Schema::TYPE_STRING.' NOT NULL',
            'file_url'=>Schema::TYPE_STRING.' NOT NULL'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_file_action','{{%action_file}}','action_id','{{%action}}','id','CASCADE');

        $this->createTable('{{%mail_list}}', [
          'id'=>'pk',
          'user_id'=>Schema::TYPE_INTEGER,
          'list_name'=> Schema::TYPE_STRING.' NOT NULL',
          'public_list'=>Schema::TYPE_BOOLEAN.' DEFAULT 0',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_list_user','{{%mail_list}}','user_id','{{%user}}','id','SET NULL');

        $this->createTable('mail_list_employee', [
          'list_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'employee_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'PRIMARY KEY (`list_id`, `employee_id`)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_list_employee','mail_list_employee','list_id', '{{%mail_list}}', 'id','CASCADE');
        $this->addForeignKey('fk_employee_list','mail_list_employee','employee_id','{{%employee}}','id','CASCADE');

        $this->createTable('{{%report}}', [
            'id'=>'pk',
            'created_at'=>Schema::TYPE_TIMESTAMP.' NOT NULL',
            'department_id'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'type'=>Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 2',
            'report_file'=>Schema::TYPE_STRING.' NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_report_department','{{%report}}','department_id','{{%department}}','id','SET NULL');

        $this->execute('INSERT INTO items VALUES ("deputy",2,"Заместители, которые проверяют проекты планов","","s:0:\"\";"),
      ("CheckPlanProject",1,"Проверка проектов планов мероприятий","","s:0:\"\";");');
        $this->execute('INSERT INTO itemchildren VALUES ("deputy","CheckPlanProject"),("admin","CheckPlanProject");');

        $this->createTable('{{%template}}', [
            'id'=>'pk',
            'start'=>Schema::TYPE_TIMESTAMP.' NOT NULL',
            'stop'=>Schema::TYPE_TIMESTAMP.' NOT NULL',
            'action'=>Schema::TYPE_TEXT.' NOT NULL',
            'repeat'=>Schema::TYPE_STRING,
            'category_id'=>Schema::TYPE_INTEGER.' DEFAULT NULL',
            'user_id'=>Schema::TYPE_INTEGER.' NOT NULL'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_template_category', '{{%template}}', 'category_id', '{{%category}}', 'id', 'SET NULL');
        $this->addForeignKey('fk_template_user', '{{%template}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        $this->createTable('template_employee', [
            'template_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'employee_id'=>Schema::TYPE_INTEGER.' NOT NULL',
            'PRIMARY KEY (`template_id`, `employee_id`)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_te_template', 'template_employee', 'template_id', '{{%template}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_te_employee', 'template_employee', 'employee_id', '{{%employee}}', 'id', 'CASCADE');

        $this->createTable('template_flag', [
          'template_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'flag_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'PRIMARY KEY (`template_id`, `flag_id`)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey('fk_tf_template', 'template_flag', 'template_id', '{{%template}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_tf_flag', 'template_flag', 'flag_id', '{{%flag}}', 'id', 'CASCADE');

        $this->createTable('template_place', [
          'template_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'place_id'=>Schema::TYPE_INTEGER.' NOT NULL',
          'PRIMARY KEY (`template_id`, `place_id`)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
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
