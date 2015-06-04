<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_181942_add_experience_triggers extends Migration
{
    public function up()
    {
        $this->execute('CREATE TRIGGER experience_insert AFTER INSERT ON tbl_experience FOR EACH ROW
            UPDATE tbl_staff_list SET count = count - 1 WHERE id = NEW.staff_unit_id');

        $this->execute('CREATE TRIGGER experience_update AFTER UPDATE ON tbl_experience FOR EACH ROW
            BEGIN
                IF NEW.staff_unit_id <> OLD.staff_unit_id THEN
                    UPDATE tbl_staff_list SET count = count - 1 WHERE id = NEW.staff_unit_id;
                    UPDATE tbl_staff_list SET count = count + 1 WHERE id = OLD.staff_unit_id;
                END IF;
            END;');

        $this->execute('CREATE TRIGGER experience_delete AFTER DELETE ON tbl_experience FOR EACH ROW
            UPDATE tbl_staff_list SET count = count + 1 WHERE id = OLD.staff_unit_id');
    }

    public function down()
    {
        echo "m150604_181942_add_experience_triggers cannot be reverted.\n";

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
