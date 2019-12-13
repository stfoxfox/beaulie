<?php

use yii\db\Migration;

class m170920_130518_create_collection extends Migration
{
    public function safeUp()
    {
        $this->createTable('collection', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string()->notNull(),
            'title_en' => $this->string(),
            'title_ua' => $this->string(),
            'title_kz' => $this->string(),
            'title_by' => $this->string(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('collection');
    }
}
