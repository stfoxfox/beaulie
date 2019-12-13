<?php

namespace common\models;

use Yii;
use common\models\gii\BaseDepartment
;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "department".
*/
class Department extends BaseDepartment
{
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    public function bubbleHtml()
    {
        return '<div class="bubble"><div class="bubble-title">'.$this->title.'</div><p class="text bubble-text">'.$this->address.'</p><p><a href="'.$this->site_url.'" class="link link_red">'.$this->site_url.'</a></p></div>';
    }

    public function getUrl($secure = false)
    {
        $url = $this->site_url;
        $parsed = parse_url($url);
        if (empty($parsed['scheme'])) {
            $url = 'http'. ($secure ? 's' : '') . '://' . ltrim($url, '/');
        }

        return $url;
    }

    public static function truncate()
    {
        $sql = 'TRUNCATE department, region CASCADE';
        return self::getDb()->createCommand($sql)->execute();
    }

    public function getCatalogCategories() {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'catalog_category_id'])
          ->viaTable('catalog_category_department', ['department_id' => 'id']);
    }
}
