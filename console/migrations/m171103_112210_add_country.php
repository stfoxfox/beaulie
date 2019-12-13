<?php

use yii\db\Migration;

class m171103_112210_add_country extends Migration
{
    public function safeUp()
    {
        $country = new \common\models\Country(['name' => 'Россия']);
        if ($country->save()) {
            $sql = 'UPDATE region SET country_id = :country_id';
            $this->execute($sql, [':country_id' => $country->id]);
        }

    }

    public function safeDown()
    {
        return true;
    }
}
