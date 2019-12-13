<?php

use yii\db\Migration;

class m171108_102344_update_department extends Migration
{
    public function safeUp()
    {
        $this->execute('UPDATE department SET is_active = TRUE;');
    }

    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171108_102344_update_department cannot be reverted.\n";

        return false;
    }
    */
}
