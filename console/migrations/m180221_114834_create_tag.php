<?php

use yii\db\Migration;

class m180221_114834_create_tag extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%tag}}');
    }
}
