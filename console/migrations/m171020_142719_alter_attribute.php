<?php

use yii\db\Migration;

class m171020_142719_alter_attribute extends Migration
{
    public function safeUp()
    {
        $this->addColumn('attribute', 'show_in_catalog_item', $this->boolean()->defaultValue(true));
    }

    public function safeDown()
    {
        $this->dropColumn('attribute', 'show_in_catalog_item');
    }
}
