<?php

use yii\db\Migration;

class m171016_123024_alter_catalog_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_item', 'min_price', $this->double());
        $this->addColumn('catalog_item', 'max_price', $this->double());

    }

    public function safeDown()
    {
        $this->dropColumn('catalog_item', 'min_price');
        $this->dropColumn('catalog_item', 'max_price');
    }
}
