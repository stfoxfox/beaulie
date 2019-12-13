<?php

namespace common\models;

use Yii;
use common\models\gii\BaseCatalogCategory
;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Cookie;

/**
* This is the model class for table "catalog_category".
*/
class CatalogCategory extends BaseCatalogCategory
{
    const COOKIE_NAME = '__category';

    /**
     * @return array
     */
    public static function getItemsForSelect()
    {
        return ArrayHelper::map(self::getItems(), 'id', 'title_ru');
    }

    /**
     * @param bool $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getItems($limit = false)
    {
        $q = self::find();
        if ($limit) $q->limit($limit);
        return $q->all();
    }

    /**
     *
     */
    public function setCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $cookie = new Cookie(['name' => self::COOKIE_NAME, 'value' => $this->id]);
        $cookies->add($cookie);
    }

    /**
     * @return static
     */
    public static function getCurrent()
    {
        $cookies = Yii::$app->request->cookies;
        if (isset($cookies[self::COOKIE_NAME])) {
            return self::find()->where(['id' => $cookies[self::COOKIE_NAME]->value])->one();
        } else {
            return self::find()->orderBy('created_at')->one();
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['catalog/index', 'id' => $this->id]);
    }

    /**
     * @return int|string
     */
    public function getItemsCount()
    {
        return $this->getCatalogItems()->count();
    }

    public function getMainFilterGroups($is_home = true)
    {
        return $this->getFilterGroups()->where(['is_quick_filter' => false, 'is_home' => $is_home])->orderBy('sort')->all();
    }

    public function getQuickFilterGroups($is_home = true)
    {
        return $this->getFilterGroups()->where(['is_quick_filter' => true, 'is_home' => $is_home])->orderBy('sort')->all();
    }

    public function getDepartments() {
        return $this->hasMany(Department::className(), ['id' => 'department_id'])
          ->viaTable('catalog_category_department', ['catalog_category_id' => 'id']);
    }

    public function getNews() {
        return $this->hasMany(News::className(), ['id' => 'news_id'])
          ->viaTable('news_catalog_category', ['catalog_category_id' => 'id']);
    }
}
