<?php

use yii\db\Migration;
use common\models\SiteSettings;

class m171002_114641_add_site_settings extends Migration
{
    public function safeUp()
    {
        $mainPageSettings = new SiteSettings();
        $mainPageSettings->title = "Настройки страницы контактов";
        $mainPageSettings->text_key="contactPage";
        $mainPageSettings->type=SiteSettings::SiteSettings_TypeArray;
        $mainPageSettings->sort=1;
        $mainPageSettings->save();

        $item = new SiteSettings();
        $item->title = "Google maps lat";
        $item->text_key="contactPageGmLat";
        $item->type=SiteSettings::SiteSettings_TypeString;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Google maps lng";
        $item->text_key="contactPageGmLng";
        $item->type=SiteSettings::SiteSettings_TypeString;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Email для связи";
        $item->text_key="contactEmail";
        $item->type=SiteSettings::SiteSettings_TypeString;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();
    }

    public function safeDown()
    {
        echo "m171002_114641_alter_site_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171002_114641_alter_site_settings cannot be reverted.\n";

        return false;
    }
    */
}
