<?php

use yii\db\Migration;

class m170920_141023_create_attribute extends Migration
{
    public function safeUp()
    {
        $this->createTable('attribute', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string()->notNull(),
            'title_en' => $this->string(),
            'title_ua' => $this->string(),
            'title_kz' => $this->string(),
            'title_by' => $this->string(),
            'ext_key' => $this->string(),
            'icon_type' => $this->string(),
            'show_in_collection' => $this->boolean(),
            'show_in_list' => $this->boolean(),
            'measure' => $this->string(),
            'type' => $this->integer()->defaultValue(10),
            'sort' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('attribute');
    }
}
