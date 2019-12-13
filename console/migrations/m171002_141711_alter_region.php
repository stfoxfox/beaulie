<?php

use yii\db\Migration;

class m171002_141711_alter_region extends Migration
{
    public function safeUp()
    {
        $this->addColumn('region', 'is_default', $this->boolean());
    }

    public function safeDown()
    {
        $this->dropColumn('region', 'is_default');
    }
}
