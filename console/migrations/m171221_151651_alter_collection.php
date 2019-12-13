<?php

use yii\db\Migration;

class m171221_151651_alter_collection extends Migration
{
    public function safeUp()
    {
        $this->addColumn('collection', 'page_id', $this->integer() . ' REFERENCES page(id) ON UPDATE CASCADE ON DELETE CASCADE');
    }

    public function safeDown()
    {
        $this->dropColumn('collection', 'page_id');
    }
}
