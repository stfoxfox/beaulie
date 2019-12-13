<?php

use yii\db\Migration;

class m171009_110700_alter_brand extends Migration
{
    public function safeUp()
    {
        $this->addColumn('brand', 'tags', 'json');
    }

    public function safeDown()
    {
        $this->dropColumn('brand', 'tags');
    }
}
