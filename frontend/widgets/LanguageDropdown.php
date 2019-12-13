<?php

namespace frontend\widgets;

use common\models\Language;
use yii\base\Widget;
use Yii;

class LanguageDropdown extends Widget
{
    public $items;

    public function init()
    {
        $appLanguage = Yii::$app->language;
        $activeLanguages = Language::getActive();

        foreach ($activeLanguages as $activeLanguage) {
            if ($activeLanguage === $appLanguage) {
                continue;
            }
            $this->items[] = $activeLanguage;
        }

        parent::init();
    }

    public function run()
    {
        return $this->render('language', ['languages' => $this->items]);
    }
}