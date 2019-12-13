<?php

use yii\db\Migration;

class m171103_095005_alter_region extends Migration
{
    public function safeUp()
    {
        $this->addColumn('region', 'country_id', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('region', 'country_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171103_095005_alter_region cannot be reverted.\n";

        return false;
    }
    */
}
