<?php

use yii\db\Migration;

class m180221_120817_create_news_tag extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%news_tag}}', [
            'news_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'PRIMARY KEY(news_id, tag_id)'
        ]);      

        $this->addForeignKey(
            'news_tag-news_id-fkey', 
            'news_tag', 
            'news_id', 
            'news', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        $this->addForeignKey(
            'news_tag-tag_id-fkey', 
            'news_tag', 
            'tag_id', 
            'tag', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%news_tag}}');
    }
}
