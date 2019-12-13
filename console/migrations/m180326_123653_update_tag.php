<?php

use yii\db\Migration;

/**
 * Class m180326_123653_update_tag
 */
class m180326_123653_update_tag extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('tag', 'sort', $this->integer()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('tag', 'sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180326_123653_update_tag cannot be reverted.\n";

        return false;
    }
    */
}
