<?php

use yii\db\Migration;

class m180222_153238_update_tag extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%tag}}', 'name');
        
        $this->addColumn('{{%tag}}', 'title_ru', $this->string());
        $this->addColumn('{{%tag}}', 'title_en', $this->string());
        $this->addColumn('{{%tag}}', 'title_kz', $this->string());
        $this->addColumn('{{%tag}}', 'title_ua', $this->string());
        $this->addColumn('{{%tag}}', 'title_by', $this->string());
    }

    public function safeDown()
    {
        $this->addColumn('{{%tag}}', 'name', $this->string());
        
        $this->dropColumn('{{%tag}}', 'title_ru');
        $this->dropColumn('{{%tag}}', 'title_en');
        $this->dropColumn('{{%tag}}', 'title_kz');
        $this->dropColumn('{{%tag}}', 'title_ua');
        $this->dropColumn('{{%tag}}', 'title_by');
    }
}
