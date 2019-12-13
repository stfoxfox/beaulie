<?php

use yii\db\Migration;

class m180111_093444_alter_attribute extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('attribute', 'show_in_collection');
        $this->dropColumn('attribute', 'show_in_list');
        $this->dropColumn('attribute', 'show_in_catalog_item');
        $this->dropColumn('attribute', 'show_collection_icon');
    }

    public function safeDown()
    {
        $this->addColumn('attribute', 'show_in_collection', $this->boolean());
        $this->addColumn('attribute', 'show_in_list', $this->boolean());
        $this->addColumn('attribute', 'show_in_catalog_item', $this->boolean()->defaultValue(true));
        $this->addColumn('attribute', 'show_collection_icon', $this->boolean()->defaultValue(false));
    }
}
