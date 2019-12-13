<?php

use yii\db\Migration;

class m180221_080705_update_attributes extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%attribute}}', 'standard_ru', $this->string());
        $this->addColumn('{{%attribute}}', 'standard_en', $this->string());
        $this->addColumn('{{%attribute}}', 'standard_ua', $this->string());
        $this->addColumn('{{%attribute}}', 'standard_kz', $this->string());
        $this->addColumn('{{%attribute}}', 'standard_by', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%attribute}}', 'standard_ru');
        $this->dropColumn('{{%attribute}}', 'standard_en');
        $this->dropColumn('{{%attribute}}', 'standard_ua');
        $this->dropColumn('{{%attribute}}', 'standard_kz');
        $this->dropColumn('{{%attribute}}', 'standard_by');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180221_080705_update_attributes cannot be reverted.\n";

        return false;
    }
    */
}
