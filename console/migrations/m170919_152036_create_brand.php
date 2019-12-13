<?php

use yii\db\Migration;

class m170919_152036_create_brand extends Migration
{
    public function safeUp()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'about_ru' => $this->text(),
            'title_en' => $this->string(),
            'about_en' => $this->text(),
            'title_kz' => $this->string(),
            'about_kz' => $this->text(),
            'title_ua' => $this->string(),
            'about_ua' => $this->text(),
            'title_by' => $this->string(),
            'about_by' => $this->text(),

            'logo_file_name' => $this->string(),
            'file_name' => $this->string(),
            'sort' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('brand');
    }
}
