<?php

use yii\db\Migration;

class m170929_150341_settings_refactoring extends Migration
{
    public function safeUp()
    {


        $this->dropColumn('site_settings','file_name');


        $this->addColumn('site_settings','file_id',$this->integer());

        $this->addForeignKey('site_settings-file_id-fkey','site_settings','file_id','file','id','set null','cascade');

    }

    public function safeDown()
    {
        echo "m170929_150341_settings_refactoring cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_150341_settings_refactoring cannot be reverted.\n";

        return false;
    }
    */
}
