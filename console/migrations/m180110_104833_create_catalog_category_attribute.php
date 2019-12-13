<?php

use yii\db\Migration;

class m180110_104833_create_catalog_category_attribute extends Migration
{
    public function safeUp()
    {
        $this->createTable('catalog_category_attribute', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer() . ' REFERENCES catalog_category(id)',
            'attribute_id' => $this->integer() . ' REFERENCES attribute(id)',
            'show_in_collection' => $this->boolean(),
            'show_in_list' => $this->boolean(),
            'show_in_catalog_item' => $this->boolean()->defaultValue(true),
            'show_collection_icon' => $this->boolean()->defaultValue(false),
            'sort' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('catalog_category_attribute');
    }
}
