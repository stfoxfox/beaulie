<?php

use yii\db\Migration;

class m170918_205104_language_table extends Migration
{
    public function safeUp()
    {

        $this->createTable('language', [
            'id' => $this->primaryKey(),
            'code'=>$this->string(2),
            'title'=>$this->string(),
            'is_active'=>$this->boolean(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()'),

        ]);

    }

    public function safeDown()
    {
        echo "m170918_205104_language_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170918_205104_language_table cannot be reverted.\n";

        return false;
    }
    */
}
