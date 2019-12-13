<?php

use yii\db\Migration;

class m171020_112547_alter_catalog_item_attribute_fkeys extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('catalog_item_attribute_catalog_item_id_fkey', 'catalog_item_attribute');
        $this->addForeignKey('catalog_item_attribute_catalog_item_id_fkey', 'catalog_item_attribute', 'catalog_item_id', 'catalog_item', 'id', 'CASCADE');
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
        echo "m171020_112547_alter_catalog_item_attribute_fkeys cannot be reverted.\n";

        return false;
    }
    */
}
