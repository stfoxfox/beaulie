<?php

use yii\db\Migration;

class m170925_074848_alter_catalog_category extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('catalog_category', 'title');
        $this->dropColumn('catalog_category', 'description');

        $this->addColumn('catalog_category', 'title_ru', $this->string());
        $this->addColumn('catalog_category', 'description_ru', $this->text());
        $this->addColumn('catalog_category', 'title_en', $this->string());
        $this->addColumn('catalog_category', 'description_en', $this->text());
        $this->addColumn('catalog_category', 'title_ua', $this->string());
        $this->addColumn('catalog_category', 'description_ua', $this->text());
        $this->addColumn('catalog_category', 'title_kz', $this->string());
        $this->addColumn('catalog_category', 'description_kz', $this->text());
        $this->addColumn('catalog_category', 'title_by', $this->string());
        $this->addColumn('catalog_category', 'description_by', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('catalog_category', 'title_ru');
        $this->dropColumn('catalog_category', 'description_ru');
        $this->dropColumn('catalog_category', 'title_en');
        $this->dropColumn('catalog_category', 'description_en');
        $this->dropColumn('catalog_category', 'title_ua');
        $this->dropColumn('catalog_category', 'description_ua');
        $this->dropColumn('catalog_category', 'title_kz');
        $this->dropColumn('catalog_category', 'description_kz');
        $this->dropColumn('catalog_category', 'title_by');
        $this->dropColumn('catalog_category', 'description_by');

        $this->addColumn('catalog_category', 'title', $this->string());
        $this->addColumn('catalog_category', 'description', $this->text());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170925_074848_alter_catalog_category cannot be reverted.\n";

        return false;
    }
    */
}
