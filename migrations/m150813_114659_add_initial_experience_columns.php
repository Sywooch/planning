<?php

use yii\db\Migration;

class m150813_114659_add_initial_experience_columns extends Migration
{
    public function up()
    {
        $this->addColumn('{{%employee}}', 'initial_experience', $this->string(8)->defaultValue(null));
        $this->addColumn('{{%employee}}', 'initial_municipal_experience', $this->string(8)->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%employee}}', 'initial_experience');
        $this->dropColumn('{{%employee}}', 'initial_municipal_experience');
    }
}
