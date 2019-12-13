<?php

use yii\db\Migration;

class m171013_111012_alter_catalog_category_filter_group extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_category_filter_group', 'is_home', $this->boolean()->defaultValue(true));
    }

    public function safeDown()
    {
        $this->dropColumn('catalog_category_filter_group', 'is_home');
    }
}
