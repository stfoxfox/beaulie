<?php

use yii\db\Migration;

class m170921_163302_alter_catalog_item_attribute extends Migration
{
    public function safeUp()
    {
        $sql = 'ALTER TABLE catalog_item_attribute ALTER COLUMN string_value_ru DROP NOT NULL';
        $this->execute($sql);
    }

    public function safeDown()
    {
        $sql = 'ALTER TABLE catalog_item_attribute ALTER COLUMN string_value_ru SET NOT NULL';
        $this->execute($sql);
    }
}
