<?php

use yii\db\Migration;

class m171103_093750_create_country extends Migration
{
    public function safeUp()
    {
        $this->createTable('country', [
            'id' => 'pk',
            'name' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('country');
    }
}
