<?php

use yii\db\Migration;

class m170926_115338_dron_working_days_type extends Migration
{
    public function safeUp()
    {

        $this->dropColumn('working_hours','type');
    }

    public function safeDown()
    {
        echo "m170926_115338_dron_working_days_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170926_115338_dron_working_days_type cannot be reverted.\n";

        return false;
    }
    */
}
