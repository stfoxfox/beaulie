<?php

use yii\db\Migration;

class m170929_101312_alter_page extends Migration
{
    public function safeUp()
    {
        $this->addColumn('page', 'banner_color', $this->string());
        $this->addColumn('page', 'banner_file_id', $this->integer()->null() . ' REFERENCES file(id)');
        $this->addColumn('page', 'banner_text', $this->text());

    }

    public function safeDown()
    {
        $this->dropColumn('page', 'banner_color');
        $this->dropColumn('page', 'banner_file_id');
        $this->dropColumn('page', 'banner_text');
    }
}
