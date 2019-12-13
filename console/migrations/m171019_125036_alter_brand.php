<?php

use yii\db\Migration;

class m171019_125036_alter_brand extends Migration
{
    public function safeUp()
    {
        $this->addColumn('brand', 'show_on_page', $this->boolean()->defaultValue(true));
    }

    public function safeDown()
    {
        $this->dropColumn('brand', 'show_on_page');
    }
}
