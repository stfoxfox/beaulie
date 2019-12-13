<?php

use yii\db\Migration;

class m171018_094705_update_catalog_item extends Migration
{
    public function safeUp()
    {
        $this->execute('UPDATE catalog_item SET is_home = true, is_business = true;');
    }

    public function safeDown()
    {
        return true;
    }
}
