<?php

use yii\db\Migration;

class m171122_133051_alter_collection extends Migration
{
    public function safeUp()
    {
        $this->addColumn('collection', 'sort', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('collection', 'sort');
    }
}
