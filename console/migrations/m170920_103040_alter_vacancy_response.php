<?php

use yii\db\Migration;

class m170920_103040_alter_vacancy_response extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('vacancy_response', 'file_name');
        $this->addColumn('vacancy_response', 'file_id', $this->integer()->null() . ' REFERENCES file(id)');
    }

    public function safeDown()
    {
        $this->dropColumn('vacancy_response', 'file_id');
        $this->addColumn('vacancy_response', 'file_name', $this->string());
    }
}
