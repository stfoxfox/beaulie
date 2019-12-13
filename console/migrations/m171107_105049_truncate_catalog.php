<?php

use yii\db\Migration;

class m171107_105049_truncate_catalog extends Migration
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
        echo "m171107_105049_truncate_catalog cannot be reverted.\n";

        return false;
    }
    */
}
