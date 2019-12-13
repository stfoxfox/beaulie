<?php

namespace frontend\models;

use common\models\Attribute;
use common\models\CatalogCategoryFilter;
use common\models\CatalogItem;
use common\models\Language;
use yii\base\ErrorException;
use yii\db\Query;

class CatalogItemSearch extends CatalogItem
{
    public $price;
    public $brand;
    public $collection;

    public $category_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['brand', 'price', 'collection'], 'safe']
        ];
    }

    /**
     * @param Query $query
     * @param $params
     * @return Query
     */
    private function searchByAttributes($query, $params)
    {
        $attributes = [];
        foreach ($params as $name => $value) {
            if (preg_match('/'.CatalogCategoryFilter::TYPE_LABEL_ATTR_PREFIX.'(\d+)/', $name, $matches)) {
                $attributes[$matches[1]] = $value;
            }
        }

        if (!empty($attributes)) {

            foreach ($attributes as $attribute_id => $values) {

                $attribute = Attribute::findOne($attribute_id);
                if (!$attribute) continue;

                switch ($attribute->type) {
                    case Attribute::TYPE_STRING:
                        $subQuery = new Query();
                        $ids = $subQuery->select('catalog_item_id')
                            ->from('catalog_item_attribute')
                            ->where(['in', 'string_value_' . Language::current(), $values])
                            ->andWhere(['attribute_id' => $attribute_id])
                            ->column();

                        $query->andWhere(['id' => $ids]);
                        break;
                    case Attribute::TYPE_NUMBER:
                        $subQuery = (new Query())->select('catalog_item_id')->from('catalog_item_attribute');
                        $subQuery->andWhere(['attribute_id' => $attribute_id]);
                        $subSubQuery = [];
                        foreach ($values as $key => $value) {
                            if ($value && is_numeric($value)) {
                                $subSubQuery[] = '(string_value_' . Language::current() . ' = \'' . $value. '\')';
                            } elseif (false !== strpos($value, '-')) {
                                list($min, $max) = explode('-', $value);
                                $subSubQuery[] = '(string_value_' . Language::current() . ' >= \'' . $min . '\' AND string_value_' . Language::current() . ' <= \'' . $max . '\')';
                            } elseif (false !== strpos($value, '>')) {
                                $subSubQuery[] = '(string_value_' . Language::current() . ' > \'' . ltrim($value, '>') . '\')';
                            } elseif (false !== strpos($value, '<')) {
                                $subSubQuery[] = '(string_value_' . Language::current() . ' < \'' . ltrim($value, '<') . '\')';
                            }
                        }

                        $ids = $subQuery->andWhere(implode(' OR ', $subSubQuery));
                        $query->andWhere(['id' => $ids]);
                        break;
                    case Attribute::TYPE_SELECT:
                        $subQuery = new Query();
                        $ids = $subQuery->select('catalog_item_id')
                            ->from('catalog_item_attribute')
                            ->where(['in', 'attribute_value_id', $values])
                            ->andWhere(['attribute_id' => $attribute_id])
                            ->column();

                        $query->andWhere(['id' => $ids]);
                        break;
                    case Attribute::TYPE_BOOL:
                        $subQuery = new Query();
                        $ids = $subQuery->select('catalog_item_id')
                            ->from('catalog_item_attribute')
                            ->where(['in','bool_value', array_map(function($value) {
                                return boolval($value) ? 'TRUE' : 'FALSE';
                            },  $values)])
                            ->andWhere(['attribute_id' => $attribute_id])
                            ->column();

                        $query->andWhere(['id' => $ids]);
                        break;
                }
            }
        }

        return $query;
    }

    /**
     * @param CatalogItem[] $items
     * @return array
     */
    private function groupByCollection($items)
    {
        $result = [];
        foreach ($items as $item) {
            $result[$item->collection_id]['items'][]    = $item;
            $result[$item->collection_id]['collection'] = $item->collection;
            $result[$item->collection_id]['sort']       = $item->collection->sort;
        }

        usort($result, function($a, $b) {
            return $a['sort'] - $b['sort'];
        });

        return $result;
    }

    /**
     * @param $params
     * @param string $formName
     * @return array
     * @throws ErrorException
     */
    public function search($params, $formName = '')
    {
        $query = CatalogItem::find();

        if ($this->category_id) {
            $query->where(['id' => (new Query())->select('catalog_item_id')
                ->from('catalog_item_category')
                ->where(['catalog_category_id' => $this->category_id])
                ->column()]);
        } else
            throw new ErrorException(\Yii::t('app.error', 'Необходимо указать категорию'));

        if ($this->is_home) {
            $query->andWhere(['is_home' => true]);
        } else {
            $query->andWhere(['is_business' => true]);
        }

        if ($this->load($params, $formName) && $this->validate()) {
            if ($this->collection) {
                $query->andWhere(['collection_id' => $this->collection]);
            }

            if ($this->brand) {
                $query->andWhere(['brand_id' => $this->brand]);
            }

            if ($this->price) {
                $subQuery = [];
                foreach ($this->price as $key => $priceRange) {
                    if (false !== strpos($priceRange, '-')) {
                        list($min, $max) = explode('-', $priceRange);
                        if ($min && $max) {
                            $subQuery[] = '((price BETWEEN ' . $min . ' AND ' . $max . ') OR (min_price BETWEEN ' . $min . ' AND '.$max.') OR (max_price BETWEEN '.$min.' AND ' . $max . '))';
                        }
                    } elseif (false !== strpos($priceRange, '>')) {
                        $subQuery[] = '((price > ' . ltrim($priceRange, '>') . ')  OR (min_price > ' . ltrim($priceRange, '>') . '))';
                    } elseif (false !== strpos($priceRange, '<')) {
                        $subQuery[] = '((price < ' . ltrim($priceRange, '<') . ') OR (max_price < ' . ltrim($priceRange, '<') . '))';
                    }


                }
                $query->andWhere(implode(' OR ', $subQuery));
            }

            $query = $this->searchByAttributes($query, $params);
        }

        return $this->groupByCollection($query->with(['collection','collection.catalogItems','file'])->all());
    }
}