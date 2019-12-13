<?php

namespace common\models;

use Yii;
use common\models\gii\BaseBrand
;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
* This is the model class for table "brand".
*/
class Brand extends BaseBrand
{
    public static function getList($condition = [])
    {
        $q = self::find();
        if ($condition) $q->andWhere($condition);
        return ArrayHelper::map($q->all(), 'id', 'title_ru');
    }

    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    public function getBrandFile()
    {
        return $this->hasOne(File::className(), ['id' => 'brand_file_id']);
    }

    public function getTags()
    {
        $tags = Json::decode($this->tags);
        if (!empty($tags)) {
            return CatalogCategory::find()->where(['id' => $tags])->all();
        }

        return null;
    }
}
