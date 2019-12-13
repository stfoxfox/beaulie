<?php

use yii\db\Migration;

/**
 * Class m180323_150329_update_news
 */
class m180323_150329_update_news extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('news', 'page_id', $this->integer());
        $this->createIndex('news-page_id-idx', 'news', 'page_id');
        $this->addForeignKey('news-page_id-fkey', 'news', 'page_id', 'page', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('news', 'page_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180323_150329_update_news cannot be reverted.\n";

        return false;
    }
    */
}
