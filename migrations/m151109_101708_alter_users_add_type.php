<?php

use yii\db\Schema;
use yii\db\Migration;

class m151109_101708_alter_users_add_type extends Migration
{
    public function up()
    {
        $this->addColumn('users', 'type', Schema::TYPE_STRING . " NOT NULL DEFAULT 'user'");
    }

    public function down()
    {

        $this->dropColumn('users', 'type');
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
