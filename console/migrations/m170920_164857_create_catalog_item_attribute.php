<?php

use yii\db\Migration;

class m170920_164857_create_catalog_item_attribute extends Migration
{
    public function safeUp()
    {
        $this->createTable('catalog_item_attribute', [
            'catalog_item_id' => $this->integer() . ' REFERENCES catalog_item(id)',
            'attribute_id' => $this->integer() . ' REFERENCES attribute(id)',
            'bool_value' => $this->boolean(),
            'string_value_ru' => $this->string()->notNull(),
            'string_value_en' => $this->string(),
            'string_value_ua' => $this->string(),
            'string_value_kz' => $this->string(),
            'string_value_by' => $this->string(),
            'attribute_value_id' => $this->integer()->null() . ' REFERENCES attribute_value(id)',
            'PRIMARY KEY(catalog_item_id, attribute_id)'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('catalog_item_attribute');
    }
}
