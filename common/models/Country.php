<?php

namespace common\models;

use Yii;
use common\models\gii\BaseCountry
;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "country".
*/
class Country extends BaseCountry
{
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
