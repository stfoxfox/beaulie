<?php

use yii\db\Migration;

class m180221_121338_news_catalog_category extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%news_catalog_category}}', [
            'news_id' => $this->integer()->notNull(),
            'catalog_category_id' => $this->integer()->notNull(),
            'PRIMARY KEY(news_id, catalog_category_id)'
        ]);      

        $this->addForeignKey(
            'news_catalog_category-news_id-fkey', 
            'news_catalog_category', 
            'news_id', 
            'news', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        $this->addForeignKey(
            'news_catalog_category-catalog_category_id-fkey', 
            'news_catalog_category', 
            'catalog_category_id', 
            'catalog_category', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_catalog_category}}');
    }
}
