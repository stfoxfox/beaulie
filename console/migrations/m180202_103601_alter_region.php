<?php

use yii\db\Migration;

class m180202_103601_alter_region extends Migration
{
    public function safeUp()
    {
        $this->addColumn('region', 'popup', $this->boolean());
    }

    public function safeDown()
    {
        $this->dropColumn('region', 'popup');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180202_103601_alter_region cannot be reverted.\n";

        return false;
    }
    */
}
