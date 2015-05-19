<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_060250_add_timestamps_columns extends Migration
{
    public function up()
    {
        $this->addColumn('{{%place}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%place}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');

        $this->addColumn('{{%department}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%department}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');

        $this->addColumn('{{%employee}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%employee}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');

        $this->addColumn('{{%action}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%action}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');


        $this->alterColumn('{{%report}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%report}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');

        $this->addColumn('{{%template}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('{{%template}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%template}}', 'created_at');
        $this->dropColumn('{{%template}}', 'updated_at');

        $this->alterColumn('{{%report}}', 'created_at', Schema::TYPE_TIMESTAMP.' NOT NULL');
        $this->dropColumn('{{%report}}', 'updated_at');

        $this->dropColumn('{{%action}}', 'created_at');
        $this->dropColumn('{{%action}}', 'updated_at');

        $this->dropColumn('{{%employee}}', 'created_at');
        $this->dropColumn('{{%employee}}', 'updated_at');

        $this->dropColumn('{{%department}}', 'created_at');
        $this->dropColumn('{{%department}}', 'updated_at');

        $this->dropColumn('{{%place}}', 'created_at');
        $this->dropColumn('{{%place}}', 'updated_at');
    }
}
