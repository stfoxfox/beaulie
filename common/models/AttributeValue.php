<?php

namespace common\models;

use Yii;
use common\models\gii\BaseAttributeValue
;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "attribute_value".
*/
class AttributeValue extends BaseAttributeValue
{
    public static function getList($attr = false) {
        $q = self::find();
        if ($attr) $q->where(['attribute_id' => $attr]);

        return ArrayHelper::map($q->all(), 'id', 'title_ru');
    }
}
