<?php

namespace common\models;

use Yii;
use common\models\gii\BaseLanguage
;

/**
* This is the model class for table "language".
*/
class Language extends BaseLanguage
{
    public static function getActive()
    {
        return self::find()->select('code')->where(['is_active' => true])->column();
    }

    public static function isCurrent($lang)
    {
        return $lang === self::current();
    }

    public static function isRussian($lang) {
        return $lang === 'ru';
    }

    public static function current()
    {
        return substr(Yii::$app->language, 0, 2);
    }
}
