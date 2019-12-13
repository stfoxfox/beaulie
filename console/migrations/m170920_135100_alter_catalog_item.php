<?php

use yii\db\Migration;

class m170920_135100_alter_catalog_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_item', 'is_new', $this->boolean());
        $this->addColumn('catalog_item', 'is_hit', $this->boolean());
        $this->addColumn('catalog_item', 'is_sale', $this->boolean());
        $this->addColumn('catalog_item', 'is_home', $this->boolean());
        $this->addColumn('catalog_item', 'is_business', $this->boolean());
        $this->addColumn('catalog_item', 'collection_id', $this->integer()->null() . ' REFERENCES collection(id)');
    }

    public function safeDown()
    {
        $this->dropColumn('catalog_item', 'is_new');
        $this->dropColumn('catalog_item', 'is_hit');
        $this->dropColumn('catalog_item', 'is_sale');
        $this->dropColumn('catalog_item', 'is_home');
        $this->dropColumn('catalog_item', 'is_business');
        $this->dropColumn('catalog_item', 'collection_id');
    }
}
