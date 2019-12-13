<?php

use yii\db\Migration;

class m171012_161910_alter_images_fkeys extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('site_settings_image_file_id_fkey', 'site_settings_image');
        $this->addForeignKey('site_settings_image_file_id_fkey', 'site_settings_image', 'file_id', 'file', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171012_161910_alter_images_fkeys cannot be reverted.\n";

        return false;
    }
    */
}
