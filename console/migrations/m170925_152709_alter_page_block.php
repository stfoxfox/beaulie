<?php

use yii\db\Migration;

class m170925_152709_alter_page_block extends Migration
{
    public function safeUp()
    {
        $this->addColumn('page_block', 'data_ru', 'jsonb');
        $this->addColumn('page_block', 'data_en', 'jsonb');
        $this->addColumn('page_block', 'data_ua', 'jsonb');
        $this->addColumn('page_block', 'data_kz', 'jsonb');
        $this->addColumn('page_block', 'data_by', 'jsonb');

        $sql = 'UPDATE page_block SET data_ru = data';
        $this->execute($sql);

        $this->dropColumn('page_block', 'data');
    }

    public function safeDown()
    {
        $this->addColumn('page_block', 'data', 'jsonb');
        $sql = 'UPDATE page_block SET data = data_ru';
        $this->execute($sql);

        $this->dropColumn('page_block', 'data_ru');
        $this->dropColumn('page_block', 'data_en');
        $this->dropColumn('page_block', 'data_ua');
        $this->dropColumn('page_block', 'data_kz');
        $this->dropColumn('page_block', 'data_by');
    }
}
