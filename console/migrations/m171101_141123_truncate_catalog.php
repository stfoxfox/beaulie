<?php

use yii\db\Migration;

class m171101_141123_truncate_catalog extends Migration
{
    public function safeUp()
    {
        $sql = 'TRUNCATE TABLE catalog_item_attribute, catalog_item, attribute, attribute_value CASCADE;';
        $this->execute($sql);
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
        echo "m171101_141123_truncate_catalog cannot be reverted.\n";

        return false;
    }
    */
}
