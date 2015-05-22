<?php

use yii\db\Schema;
use yii\db\Migration;

class m150522_141037_drop_genitive_column extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%employee}}', 'useGenitive');
    }

    public function down()
    {
        $this->addColumn('{{%employee}}', 'useGenitive', Schema::TYPE_BOOLEAN.' NOT NULL');
    }
}
