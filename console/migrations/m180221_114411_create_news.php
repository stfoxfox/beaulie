<?php

use yii\db\Migration;

class m180221_114411_create_news extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(),
            'title' => $this->string(),
            'text' => $this->text(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);

        $this->addForeignKey(
            'news-file_id-fkey', 
            'news', 
            'file_id', 
            'file', 
            'id', 
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
