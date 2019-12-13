<?php

namespace common\models;

use Yii;
use common\models\gii\BaseNews
;

/**
* This is the model class for table "news".
*/
class News extends BaseNews
{
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    public function getCatalogCategories() {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'catalog_category_id'])
          ->viaTable('news_catalog_category', ['news_id' => 'id']);
    }

    public function getTags() {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
          ->viaTable('news_tag', ['news_id' => 'id']);
    }

    public function getPage(){
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
