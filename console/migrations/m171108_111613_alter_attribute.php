<?php

use yii\db\Migration;

class m171108_111613_alter_attribute extends Migration
{
    public function safeUp()
    {
        $this->addColumn('attribute', 'show_collection_icon', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('attribute', 'show_collection_icon');
    }
}
