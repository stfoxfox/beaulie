<?php

use yii\db\Migration;

class m180222_125413_createa_index extends Migration
{
    public function safeUp()
    {
        $this->createIndex('catalog_category_department-catalog_category_id-idx', 'catalog_category_department', 'catalog_category_id');
        $this->createIndex('catalog_category_department-department_id-idx', 'catalog_category_department', 'department_id');

        $this->createIndex('news_tag-news_id-idx', 'news_tag', 'news_id');
        $this->createIndex('news_tag-tag_id-idx', 'news_tag', 'tag_id');

        $this->createIndex('news_catalog_category-news_id-idx', 'news_catalog_category', 'news_id');
        $this->createIndex('news_catalog_category-catalog_category_id-idx', 'news_catalog_category', 'catalog_category_id');
    }

    public function safeDown()
    {
        echo "m180222_125413_createa_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180222_125413_createa_index cannot be reverted.\n";

        return false;
    }
    */
}
