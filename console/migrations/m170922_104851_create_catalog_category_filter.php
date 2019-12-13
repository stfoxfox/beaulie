<?php

use yii\db\Migration;

class m170922_104851_create_catalog_category_filter extends Migration
{
    public function safeUp()
    {
        $this->createTable('catalog_category_filter', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_en' => $this->string(),
            'title_ua' => $this->string(),
            'title_kz' => $this->string(),
            'title_by' => $this->string(),
            'catalog_category_filter_group_id' => $this->integer() . ' REFERENCES catalog_category_filter_group(id)',
            'catalog_category_id' => $this->integer() . ' REFERENCES catalog_category(id)',
            'attribute_id' => $this->integer() . ' REFERENCES attribute(id)',
            'type' => $this->smallInteger()->defaultValue(10),
            'view_type' => $this->smallInteger()->defaultValue(10),
            'sort' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('catalog_category_filter');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170922_104851_create_catalog_category_filter cannot be reverted.\n";

        return false;
    }
    */
}
