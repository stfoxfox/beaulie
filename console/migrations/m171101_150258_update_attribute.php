<?php

use yii\db\Migration;

class m171101_150258_update_attribute extends Migration
{
    public function safeUp()
    {
        $sql = "UPDATE attribute SET show_in_collection = FALSE, show_in_list = FALSE, show_in_catalog_item = FALSE";
        $this->execute($sql);
    }

    public function safeDown()
    {
        return true;
    }

}
