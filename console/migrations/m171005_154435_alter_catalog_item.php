<?php

use yii\db\Migration;

class m171005_154435_alter_catalog_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_item', 'brand_id', $this->integer() . ' REFERENCES brand(id)');
    }

    public function safeDown()
    {
        $this->dropColumn('catalog_item', 'brand_id');
    }
}
