<?php

namespace common\models;

use common\components\MyExtensions\MyImagePublisher;
use Yii;
use common\models\gii\BaseCatalogItem
;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
* This is the model class for table "catalog_item".
*/
class CatalogItem extends BaseCatalogItem
{
    /**
     * @param $attr Attribute
     * @return boolean
     */
    public function isAttributeLinked($attr)
    {
        $sql = 'SELECT COUNT(*) FROM catalog_item_attribute WHERE catalog_item_id=:cid AND attribute_id=:aid';

        return (bool) $this->getDb()->createCommand($sql, [
            ':cid' => $this->id,
            ':aid' => $attr->id
        ])->queryScalar();
    }

    public static function getHomeCount($category = false)
    {
        $q = self::find()->where(['is_home' => true]);
        if ($category) {
            $q->leftJoin('catalog_item_category', 'catalog_item.id = catalog_item_category.catalog_item_id');
            $q->andFilterWhere(['catalog_item_category.catalog_category_id' => $category]);
        }

        return $q->count();
    }

    public static function getBusinessCount($category = false)
    {
        $q = self::find()->where(['is_business' => true]);
        if ($category) {
            $q->leftJoin('catalog_item_category', 'catalog_item.id = catalog_item_category.catalog_item_id');
            $q->andFilterWhere(['catalog_item_category.catalog_category_id' => $category]);
        }

        return $q->count();
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    public function getViewUrl($isHome = false, $shortCut = false)
    {
        return Url::toRoute(['catalog/view',
            'collection_id' => $this->collection_id,
            'item_id' => $this->id,
            'is_home' => null !== $isHome ? $isHome : $this->is_home
        ]) . ($shortCut ? '#' . $this->id : '');
    }

    public function getInfo($category_id, $order)
    {
        $result = [];
        if (!empty($order)) {
            foreach ($this->getCategoryAttributes($category_id, ['show_in_list' => true, 'attribute_id' => $order]) as $attributeModel) {
                /* @var Attribute $attributeModel */
                $result[$attributeModel->title] = $attributeModel->getValueFor($this, Language::current());
                if ($attributeModel->type === Attribute::TYPE_NUMBER) {
                    $result[$attributeModel->title] .= " $attributeModel->measure";
                }
            }
        }

        return $result;
    }

    /*
     * {&quot;img&quot;: &quot;images/content/product-slide-01.jpg&quot;, &quot;title&quot;: &quot;FOREST 916L&quot;,&quot;info&quot;: [&quot;Доска&quot;, &quot;6,8 х 100 М&quot;,&quot;1,5/3/4 М&quot;, &quot;200-400 Р&quot;, &quot;23&quot;,&quot;1,9 мм&quot;,&quot;0,15 мм&quot;,&quot;1 кг/м²&quot;,&quot;пена&quot;,&quot;12 лет&quot;,&quot;КМ2&quot;,&quot;Б2&quot;,&quot;0,02&quot;,&quot;14&quot;,&quot;≤ 0,1&quot;,&quot;тиснение&quot;,&quot;4110*&quot;]}
     */
    public function asJson($category_id, $attributesOrder)
    {
        $json = [];
        $json['img'] = $this->file ? (new MyImagePublisher($this->file))->MyThumbnail(300, 300, 'file_name', self::tableName()) : '';
        $json['title'] = $this->title;
        $json['info'] = array_values($this->getInfo($category_id, $attributesOrder));
        return htmlentities(Json::encode($json));
    }

    /**
     * @param int $category_id
     * @param static[] $items
     * @return array
     */
    public static function compare($category_id, $items)
    {
        if (!empty($items) && count($items) >= 2) {
            $item = array_shift($items);
        } else
            return [];

        $order = [];
        foreach ($item->getCategoryAttributes($category_id, ['show_in_list' => true]) as $attribute) {
            $order[] = ['id' => $attribute->id, 'title' => $attribute->title];
        }

        foreach ($items as $item) {
            foreach ($order as $key => $attr) {
                if ($item->getCategoryAttributes($category_id, ['show_in_list' => true, 'attribute_id' => $attr['id']])[0] === null) {
                    unset($order[$key]);
                }
            }
        }

        return $order;
    }

    /**
     * @param int $category_id
     * @param null|string|array $condition
     * @return Attribute[]
     */
    public static function getCategoryAttributes($category_id, $condition = null)
    {
        $result = [];
        if ($category_id) {
            $query = new Query();
            $query->select('*')
                ->from('catalog_category_attribute')
                ->where(['category_id' => $category_id]);
            if ($condition) {
                $query->andWhere($condition);
            }
            $attrData = $query->all();

            foreach ($attrData as $attr) {
                $attrModel = Attribute::findOne($attr['attribute_id']);
                foreach ($attr as $param => $value) {
                    if (property_exists($attrModel, $param)) {
                        $attrModel->$param = $value;
                    }
                }
                $result[] = $attrModel;
            }
        }

        return $result;
    }

    /**
     * @return boolean
     */
    public static function truncate()
    {
        $sql = "TRUNCATE TABLE catalog_item, catalog_item_attribute, attribute, attribute_value CASCADE;";
        $db = self::getDb();
        return $db->createCommand($sql)->execute();
    }
}
