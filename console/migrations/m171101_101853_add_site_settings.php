<?php

use yii\db\Migration;
use common\models\SiteSettings;

class m171101_101853_add_site_settings extends Migration
{
    public function safeUp()
    {
        $keyLabels = [
            'facebook' => 'Facebook',
            'vk' => 'Vk',
            'instagram' => 'Instagram',
            'in' => 'LinkedIn',
            'twitter' => 'Twitter',
            'telegram' => 'Telegram'
        ];

        foreach ($keyLabels as $key => $label) {
            if (!SiteSettings::get($key)) {
                $model = new SiteSettings();
                $model->title = $label;
                $model->text_key=$key;
                $model->type=SiteSettings::SiteSettings_TypeString;
                $model->sort=1;
                $model->save();
            }
        }
    }

    public function safeDown()
    {
        return true;
    }
}
