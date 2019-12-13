<?php

use yii\db\Migration;

class m170919_142335_create_vacancy_response extends Migration
{
    public function safeUp()
    {
        $this->createTable('vacancy_response', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'info' => $this->string(),
            'file_name' => $this->string(),
            'department' => $this->string()->notNull(),
            'vacancy_id' => $this->integer()->notNull() . ' REFERENCES vacancy(id)',
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('vacancy_response');
    }
}
