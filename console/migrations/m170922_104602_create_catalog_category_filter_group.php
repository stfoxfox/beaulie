<?php

use yii\db\Migration;

class m170922_104602_create_catalog_category_filter_group extends Migration
{
    public function safeUp()
    {
        $this->createTable('catalog_category_filter_group', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_en' => $this->string(),
            'title_ua' => $this->string(),
            'title_kz' => $this->string(),
            'title_by' => $this->string(),
            'catalog_category_id' => $this->integer() . ' REFERENCES catalog_category(id)',
            'sort' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('catalog_category_filter_group');
    }
}
