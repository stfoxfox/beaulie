<?php

use yii\db\Migration;

class m170920_144927_create_attribute_value extends Migration
{
    public function safeUp()
    {
        $this->createTable('attribute_value', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string()->notNull(),
            'title_en' => $this->string(),
            'title_ua' => $this->string(),
            'title_kz' => $this->string(),
            'title_by' => $this->string(),
            'attribute_id' => $this->integer() . ' REFERENCES attribute(id)',
            'ext_key' => $this->string(),
            'sort' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('attribute_value');
    }
}
