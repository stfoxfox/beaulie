<?php

use yii\db\Migration;

class m171020_112829_remove_catalog_item_duplicates extends Migration
{
    public function safeUp()
    {
        $sql = 'DELETE FROM catalog_item WHERE ctid NOT IN(SELECT min(ctid) FROM catalog_item GROUP BY title, collection_id, brand_id);';
        $this->execute($sql);
    }

    public function safeDown()
    {
        return true;
    }
}
