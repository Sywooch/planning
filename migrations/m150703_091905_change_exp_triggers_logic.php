<?php

use yii\db\Migration;

class m150703_091905_change_exp_triggers_logic extends Migration
{
    public function up()
    {
        $this->execute('DROP TRIGGER IF EXISTS experience_insert');
        $this->execute('DROP TRIGGER IF EXISTS experience_update');
        $this->execute('DROP TRIGGER IF EXISTS experience_delete');
        $this->execute('CREATE TRIGGER experience_insert AFTER INSERT ON tbl_experience FOR EACH ROW
            BEGIN
                IF (NEW.stop IS NULL OR (NEW.stop IS NOT NULL AND NEW.stop > now())) THEN
                    UPDATE tbl_staff_list SET count = count - 1 WHERE id = NEW.staff_unit_id;
                END IF;
            END;');

        $this->execute(
            'CREATE TRIGGER experience_update AFTER UPDATE ON tbl_experience FOR EACH ROW
            BEGIN
                IF (NEW.staff_unit_id <> OLD.staff_unit_id) THEN
                IF (OLD.stop IS NULL AND NEW.stop IS NULL) THEN
                    UPDATE tbl_staff_list SET count = count - 1 WHERE id = NEW.staff_unit_id;
                    UPDATE tbl_staff_list SET count = count + 1 WHERE id = OLD.staff_unit_id;
                END IF;
                ELSE
                    IF (NEW.stop <> OLD.stop) THEN
                        IF (NEW.stop IS NOT NULL AND NEW.stop < now()) THEN
                            UPDATE tbl_staff_list SET count = count + 1 WHERE id = OLD.staff_unit_id;
                        ELSEIF ((NEW.stop IS NULL AND OLD.stop < now()) OR (NEW.stop IS NOT NULL AND NEW.stop > now() AND OLD.stop < now())) THEN
                            UPDATE tbl_staff_list SET count = count - 1 WHERE id = OLD.staff_unit_id;
                        END IF;
                    END IF;
                END IF;
            END;'
        );

        $this->execute('CREATE TRIGGER experience_delete AFTER DELETE ON tbl_experience FOR EACH ROW
            BEGIN
                IF (OLD.stop IS NULL OR OLD.stop > now()) THEN
                    UPDATE tbl_staff_list SET count = count + 1 WHERE id = OLD.staff_unit_id;
                END IF;
            END;');
    }

    public function down()
    {
        echo "m150703_091905_change_exp_triggers_logic cannot be reverted.\n";

        return false;
    }
}
