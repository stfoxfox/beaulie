<?php

use yii\db\Migration;

class m171006_143622_alter_brand extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('brand', 'logo_file_name');
        $this->addColumn('brand', 'brand_file_id', $this->integer());
        $this->dropForeignKey('catalog_item_brand_id_fkey', 'catalog_item');
    }

    public function safeDown()
    {
        return true;
    }
}
