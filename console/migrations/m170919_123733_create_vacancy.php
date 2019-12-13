<?php

use yii\db\Migration;

class m170919_123733_create_vacancy extends Migration
{
    public function safeUp()
    {
        $this->createTable('vacancy', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string()->notNull(),
            'title_en' => $this->string(),
            'title_ua' => $this->string(),
            'title_kz' => $this->string(),
            'title_by' => $this->string(),

            'description_ru' => $this->text(),
            'description_en' => $this->text(),
            'description_ua' => $this->text(),
            'description_kz' => $this->text(),
            'description_by' => $this->text(),

            'requirements_ru' => $this->text(),
            'requirements_en' => $this->text(),
            'requirements_ua' => $this->text(),
            'requirements_kz' => $this->text(),
            'requirements_by' => $this->text(),

            'conditions_ru' => $this->text(),
            'conditions_en' => $this->text(),
            'conditions_ua' => $this->text(),
            'conditions_kz' => $this->text(),
            'conditions_by' => $this->text(),

            'sort' => $this->integer(),
            'is_active' => $this->boolean()->defaultValue(false),

            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('vacancy');
    }
}
