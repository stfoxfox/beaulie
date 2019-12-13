<?php

use yii\db\Migration;
use common\models\SiteSettings;

class m171009_133838_add_site_settings extends Migration
{
    public function safeUp()
    {
        $model = new SiteSettings();
        $model->title = "Email для страницы Карьера";
        $model->text_key="careerEmail";
        $model->type=SiteSettings::SiteSettings_TypeString;
        $model->sort=1;
        $model->save();
    }

    public function safeDown()
    {
        SiteSettings::findOne(['text_key' => 'careerEmail'])->delete();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171009_133838_add_site_settings cannot be reverted.\n";

        return false;
    }
    */
}
