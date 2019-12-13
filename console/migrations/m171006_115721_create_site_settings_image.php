<?php

use yii\db\Migration;

class m171006_115721_create_site_settings_image extends Migration
{
    public function safeUp()
    {
        $this->createTable('site_settings_image', [
            'file_id' => $this->integer() . ' REFERENCES file(id)',
            'site_settings_id' => $this->integer() . ' REFERENCES site_settings(id)',
            'PRIMARY KEY(file_id, site_settings_id)'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('site_settings_image');
    }
}
