<?php

namespace common\models;

use Yii;
use common\models\gii\BaseTag;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "tag".
*/
class Tag extends BaseTag
{
    public function getNews() {
        return $this->hasMany(News::className(), ['id' => 'news_id'])
          ->viaTable('news_tag', ['tag_id' => 'id']);
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title_ru');
    }
}
