<?php

use yii\db\Migration;

class m150803_081128_add_option_table_for_action extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%option}}', [
            'id' => $this->primaryKey(),
            'option' => $this->string()->notNull(),
            'duration' => $this->time()->notNull(),
        ], $tableOptions);
        $this->createIndex('ix_option', '{{%option}}', ['option'], true);

        $this->createTable('action_option', [
            'action_id' => $this->integer()->notNull(),
            'option_id' => $this->integer()->notNull(),
            'PRIMARY KEY (action_id, option_id)'
        ], $tableOptions);
        $this->addForeignKey('fk_action_option_action', 'action_option', 'action_id', '{{%action}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_action_option_option', 'action_option', 'option_id', '{{%option}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('ix_action_option', 'action_option', ['action_id', 'option_id'], true);

        $this->createTable('flag_option', [
            'flag_id' => $this->integer()->notNull(),
            'option_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_flag_option_flag', 'flag_option', 'flag_id', '{{%flag}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_flag_option_option', 'flag_option', 'option_id', '{{%option}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('ix_flag_option', 'flag_option', ['flag_id', 'option_id'], true);

        $this->execute('
            CREATE TRIGGER add_flag_with_option AFTER INSERT ON action_flag FOR EACH ROW
            BEGIN
                DECLARE v_finished INTEGER DEFAULT 0;
                DECLARE v_option INTEGER DEFAULT NULL;
                DECLARE option_cursor CURSOR FOR SELECT option_id FROM flag_option WHERE flag_id=new.flag_id;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;
                OPEN option_cursor;
                add_option: LOOP
                    FETCH option_cursor INTO v_option;
                    IF v_finished = 1 THEN
                        LEAVE add_option;
                    END IF;
                    INSERT INTO action_option(action_id, option_id) VALUES (new.action_id, v_option);
                END LOOP add_option;
                CLOSE option_cursor;
            END;
        ');
        $this->execute('
            CREATE TRIGGER uncheck_flag_with_option AFTER DELETE ON action_flag FOR EACH ROW
            BEGIN
                DECLARE v_finished INTEGER DEFAULT 0;
                DECLARE v_option INTEGER DEFAULT NULL;
                DECLARE option_cursor CURSOR FOR SELECT option_id FROM flag_option WHERE flag_id=old.flag_id;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;
                OPEN option_cursor;
                    add_option: LOOP
                        FETCH option_cursor INTO v_option;
                        IF v_finished = 1 THEN
                            LEAVE add_option;
                        END IF;
                        DELETE FROM action_option WHERE action_id=old.action_id AND option_id=v_option;
                    END LOOP add_option;
                CLOSE option_cursor;
            END;
        ');

        $this->execute('
            CREATE TRIGGER add_flag_option AFTER INSERT ON flag_option FOR EACH ROW
            BEGIN
                DECLARE v_finished INTEGER DEFAULT 0;
                DECLARE v_action INTEGER DEFAULT NULL;
                DECLARE action_cursor CURSOR FOR SELECT action_id FROM action_flag WHERE flag_id=new.flag_id;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;
                OPEN action_cursor;
                add_option: LOOP
                    FETCH action_cursor INTO v_action;
                    IF v_finished = 1 THEN
                        LEAVE add_option;
                    END IF;
                    INSERT INTO action_option(action_id, option_id) VALUES (v_action, new.option_id);
                END LOOP add_option;
                CLOSE action_cursor;
            END;
        ');

        $this->execute('
            CREATE TRIGGER delete_flag_option AFTER DELETE ON flag_option FOR EACH ROW
            BEGIN
                DECLARE v_finished INTEGER DEFAULT 0;
                DECLARE v_action INTEGER DEFAULT NULL;
                DECLARE action_cursor CURSOR FOR SELECT action_id FROM action_flag WHERE flag_id=old.flag_id;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;
                OPEN action_cursor;
                add_option: LOOP
                    FETCH action_cursor INTO v_action;
                    IF v_finished = 1 THEN
                        LEAVE add_option;
                    END IF;
                    DELETE FROM action_option WHERE action_id=v_action AND option_id=old.option_id;
                END LOOP add_option;
                CLOSE action_cursor;
            END;
        ');
    }

    public function down()
    {
        $this->execute('DROP TRIGGER delete_flag_option');
        $this->execute('DROP TRIGGER add_flag_option');
        $this->execute('DROP TRIGGER uncheck_flag_with_option');
        $this->execute('DROP TRIGGER add_flag_with_option');
        $this->dropTable('flag_option');
        $this->dropTable('action_option');
        $this->dropTable('{{%option}}');
    }
}
