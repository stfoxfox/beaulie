<?php

use yii\db\Migration;

class m170920_092827_alter_brand extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('brand', 'file_name');
        $this->addColumn('brand', 'file_id', $this->integer()->null() . ' REFERENCES file(id)');
    }

    public function safeDown()
    {
        $this->dropColumn('brand', 'file_id');
        $this->addColumn('brand', 'file_name', $this->string());
    }
}
