<?php

use yii\db\Migration;

class m180122_141658_delete_empty_attributes extends Migration
{
    public function safeUp()
    {
        $this->execute('DELETE FROM catalog_item_attribute WHERE string_value_ru IS NULL AND bool_value IS NULL AND attribute_value_id IS NULL;');
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
        echo "m180122_141658_delete_empty_attributes cannot be reverted.\n";

        return false;
    }
    */
}
