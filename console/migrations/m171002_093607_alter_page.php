<?php

use yii\db\Migration;

class m171002_093607_alter_page extends Migration
{
    public function safeUp()
    {
        $this->addColumn('page', 'title_ru', $this->string());
        $this->addColumn('page', 'title_en', $this->string());
        $this->addColumn('page', 'title_ua', $this->string());
        $this->addColumn('page', 'title_kz', $this->string());
        $this->addColumn('page', 'title_by', $this->string());

        $sql = 'UPDATE page SET title_ru = title';
        $this->execute($sql);

        $this->dropColumn('page', 'title');

        $this->addColumn('page', 'description_ru', $this->string());
        $this->addColumn('page', 'description_en', $this->string());
        $this->addColumn('page', 'description_ua', $this->string());
        $this->addColumn('page', 'description_kz', $this->string());
        $this->addColumn('page', 'description_by', $this->string());

        $sql = 'UPDATE page SET description_ru = description';
        $this->execute($sql);

        $this->dropColumn('page', 'description');

        $this->addColumn('page', 'html_text_ru', $this->text());
        $this->addColumn('page', 'html_text_en', $this->text());
        $this->addColumn('page', 'html_text_ua', $this->text());
        $this->addColumn('page', 'html_text_kz', $this->text());
        $this->addColumn('page', 'html_text_by', $this->text());

        $sql = 'UPDATE page SET html_text_ru = html_text';
        $this->execute($sql);

        $this->dropColumn('page', 'html_text');

        $this->addColumn('page', 'banner_text_ru', $this->text());
        $this->addColumn('page', 'banner_text_en', $this->text());
        $this->addColumn('page', 'banner_text_ua', $this->text());
        $this->addColumn('page', 'banner_text_kz', $this->text());
        $this->addColumn('page', 'banner_text_by', $this->text());

        $sql = 'UPDATE page SET banner_text_ru = banner_text';
        $this->execute($sql);

        $this->dropColumn('page', 'banner_text');
    }

    public function safeDown()
    {
        echo "m171002_093607_alter_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171002_093607_alter_page cannot be reverted.\n";

        return false;
    }
    */
}
