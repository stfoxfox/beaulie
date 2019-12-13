<?php

use yii\db\Migration;

class m171003_094925_alter_catalog_category extends Migration
{
    public function safeUp()
    {
        $this->addColumn('catalog_category', 'business_description_ru', $this->text());
        $this->addColumn('catalog_category', 'business_description_en', $this->text());
        $this->addColumn('catalog_category', 'business_description_ua', $this->text());
        $this->addColumn('catalog_category', 'business_description_kz', $this->text());
        $this->addColumn('catalog_category', 'business_description_by', $this->text());
        $this->addColumn('catalog_category', 'business_color', $this->string());
        $this->addColumn('catalog_category', 'home_color', $this->string());
        $this->addColumn('catalog_category', 'business_file_id', $this->integer() . ' REFERENCES file(id)');
    }

    public function safeDown()
    {
        return true;
    }
}
