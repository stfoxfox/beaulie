<?php

use common\models\SiteSettings;
use yii\db\Migration;

class m170929_205108_add_site_settings extends Migration
{
    public function safeUp()
    {


        $mainPageSettings = new SiteSettings();
        $mainPageSettings->title = "Настройки главной страницы";
        $mainPageSettings->text_key="mainPage";
        $mainPageSettings->type=SiteSettings::SiteSettings_TypeArray;
        $mainPageSettings->sort=1;
        $mainPageSettings->save();



        $item = new SiteSettings();
        $item->title = "Заголовок для бизнеса";
        $item->text_key="mainPageBusinessHeader";
        $item->type=SiteSettings::SiteSettings_TypeString;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Заголовок для дома";
        $item->text_key="mainPageHomeHeader";
        $item->type=SiteSettings::SiteSettings_TypeString;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Текст для дома";
        $item->text_key="mainPageHomeText";
        $item->type=SiteSettings::SiteSettings_TypeText;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Заголовок для бизнеса";
        $item->text_key="mainPageBusinessText";
        $item->type=SiteSettings::SiteSettings_TypeText;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Галерея для дома";
        $item->text_key="mainPageHomeGallery";
        $item->type=SiteSettings::SiteSettings_TypeGallery;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();

        $item = new SiteSettings();
        $item->title = "Галерея для бизнеса";
        $item->text_key="mainPageBusinessGallery";
        $item->type=SiteSettings::SiteSettings_TypeGallery;
        $item->parent_id=$mainPageSettings->id;
        $item->sort=1;
        $item->save();



    }

    public function safeDown()
    {
        echo "m170929_205108_add_site_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170929_205108_add_site_settings cannot be reverted.\n";

        return false;
    }
    */
}
