<?php

use yii\db\Migration;

class m171003_105913_alter_catalog_category_filter_group extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_category_filter_group', 'is_quick_filter', $this->boolean());
    }

    public function safeDown()
    {
        $this->dropColumn('catalog_category_filter_group', 'is_quick_filter');
    }
}
