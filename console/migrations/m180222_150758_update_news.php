<?php

use yii\db\Migration;

class m180222_150758_update_news extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%news}}', 'title');
        $this->dropColumn('{{%news}}', 'text');
        
        $this->addColumn('{{%news}}', 'title_ru', $this->string());
        $this->addColumn('{{%news}}', 'title_en', $this->string());
        $this->addColumn('{{%news}}', 'title_kz', $this->string());
        $this->addColumn('{{%news}}', 'title_ua', $this->string());
        $this->addColumn('{{%news}}', 'title_by', $this->string());

        $this->addColumn('{{%news}}', 'text_ru', $this->string());
        $this->addColumn('{{%news}}', 'text_en', $this->string());
        $this->addColumn('{{%news}}', 'text_kz', $this->string());
        $this->addColumn('{{%news}}', 'text_ua', $this->string());
        $this->addColumn('{{%news}}', 'text_by', $this->string());
    }

    public function safeDown()
    {
        $this->addColumn('{{%news}}', 'title', $this->string());
        $this->addColumn('{{%news}}', 'text', $this->text());
        
        $this->dropColumn('{{%news}}', 'title_ru');
        $this->dropColumn('{{%news}}', 'title_en');
        $this->dropColumn('{{%news}}', 'title_kz');
        $this->dropColumn('{{%news}}', 'title_ua');
        $this->dropColumn('{{%news}}', 'title_by');

        $this->dropColumn('{{%news}}', 'text_ru');
        $this->dropColumn('{{%news}}', 'text_en');
        $this->dropColumn('{{%news}}', 'text_kz');
        $this->dropColumn('{{%news}}', 'text_ua');
        $this->dropColumn('{{%news}}', 'text_by');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180222_150758_update_news cannot be reverted.\n";

        return false;
    }
    */
}
