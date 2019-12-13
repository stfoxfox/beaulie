<?php

namespace common\models;

use Yii;
use common\models\gii\BaseCatalogCategoryFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class CatalogCategoryFilter
 * @package common\models
 * @inheritdoc
 *
 * @property array $values
 */
class CatalogCategoryFilter extends BaseCatalogCategoryFilter
{
    /**
     * Name of query string params
     */
    const TYPE_LABEL_PRICE = 'price';
    const TYPE_LABEL_BRAND = 'brand';
    const TYPE_LABEL_COLLECTION = 'collection';

    const TYPE_LABEL_ATTR_PREFIX = 'attribute_';

    /**
     * @param string $formName
     * @return string
     */
    public function getInputName($formName = '')
    {
        return !empty($formName) ? $formName . '[' . $this->getTypeName() . '[]]' : $this->getTypeName() . '[]';
    }

    public function getShortInputName($formName = '')
    {
        return !empty($formName) ? $formName . '[' . $this->getTypeName() . ']' : $this->getTypeName();
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        switch ($this->type) {
            case self::TYPE_PRICE:
                return self::TYPE_LABEL_PRICE;
            case self::TYPE_BRAND:
                return self::TYPE_LABEL_BRAND;
            case self::TYPE_COLLECTION:
                return self::TYPE_LABEL_COLLECTION;
            case self::TYPE_ATTR:
                return self::TYPE_LABEL_ATTR_PREFIX . $this->attributeModel->id;
        }
    }

    protected function makeRange($min, $max, $round = -1)
    {
        $step = ($max - $min) / 5;
        $newValues = [];
        for ($i = 0; $i < 5; ++$i) {
            $mmin =  false !== $round ? round($min + ($step * $i), $round) : $min + ($step * $i);
            $mmax =  false !== $round ? round($min + ($step * ($i +1)), $round) : $min + ($step * ($i +1));
            $idxVal = $mmin . '-' . $mmax;
            $newValues[$idxVal] = $idxVal;
        }

        return $newValues;
    }
    /**
     * @return array (label => value)
     */
    public function getValues()
    {
        $currentIds = (new Query())
            ->select('catalog_item_id')
            ->from('catalog_item_category')
            ->where(['catalog_category_id' => $this->catalog_category_id])
            ->column();


        switch ($this->type) {
            case self::TYPE_PRICE:
                $query = new Query();
                $prices = $query
                    ->select('MIN(price) as price1,  MIN(min_price) as price2, MAX(price) as price3, MAX(max_price) as price4')
                    ->from('catalog_item')
                    ->where([
                        'id' => $currentIds
                    ])
                    ->all();



                if (empty($prices[0]['price1'])) {
                    $min = $prices[0]['price2'];
                } elseif(empty($prices[0]['price2'])) {
                    $min = $prices[0]['price1'];
                } else {
                    $min = min($prices[0]['price1'], $prices[0]['price2']);
                }

                if (empty($prices[0]['price3'])) {
                    $max = $prices[0]['price4'];
                } elseif(empty($prices[0]['price4'])) {
                    $max = $prices[0]['price3'];
                } else {
                    $max = max($prices[0]['price3'], $prices[0]['price4']);
                }

                return $this->makeRange($min, $max);

            case self::TYPE_BRAND:
                return Brand::getList([
                    'id' => (new Query())
                        ->select('brand_id')
                        ->from('catalog_item')
                        ->where(['id' => $currentIds])
                        //->all()
                ]);
            case self::TYPE_COLLECTION:
                return Collection::getItemsForSelect([
                    'id' => (new Query())
                        ->select('collection_id')
                        ->from('catalog_item')
                        ->where(['id' => $currentIds])
                       // ->all()
                ]);
            case self::TYPE_ATTR:
                switch ($this->attributeModel->type) {
                    case Attribute::TYPE_STRING:
                    case Attribute::TYPE_NUMBER:
                        $values = ArrayHelper::map((new Query())
                            ->select('string_value_' . Language::current())
                            ->from('catalog_item_attribute')
                            ->where(['attribute_id' => $this->attribute_id, 'catalog_item_id' => $currentIds])
                            ->all(), 'string_value_' . Language::current(), 'string_value_' . Language::current());

                        if (
                            $this->attributeModel->type === Attribute::TYPE_NUMBER &&
                            $this->view_type === self::VIEW_TYPE_SELECT_RANGE &&
                            count($values)
                        ) {

                            $min = min($values);
                            $max = max($values);
                            return $this->makeRange($min, $max, false);
                        }

                        return $values;

                    case Attribute::TYPE_SELECT:
                        return ArrayHelper::map((new Query())
                            ->select('id, title_' . Language::current())
                            ->from('attribute_value')
                            ->where([
                                'id' => (new Query())
                                    ->select('attribute_value_id')
                                    ->from('catalog_item_attribute')
                                    ->where(['attribute_id' => $this->attribute_id, 'catalog_item_id' => $currentIds])
                                    ->column()
                            ])
                            ->all(), 'id', 'title_' . Language::current());
                }

        }
    }

    /**
     * @return array
     */
    public function getValuesByAlphabet() {
        $values = $this->values;
        asort($values);
        return $this->byAlphabet($values);
    }

    public function isChecked($value)
    {
        if (isset($_REQUEST[$this->getShortInputName()])) {
            return in_array($value, $_REQUEST[$this->getShortInputName()]);
        } else {
            return false;
        }
    }

    /**
     * @param $array
     * @return array
     */
    protected function byAlphabet($array) {
        $mem = null;
        $sorting = [];

        foreach($array as $key => $item) {
            // первая буква
            $letter = mb_substr($item, 0, 1, 'utf-8');

            // текущая буква не равна предыдущей
            if ($letter != $mem) {
                $mem = $letter;
                $sorting[$mem] = [];
            }

            $sorting[$mem][$key] = $item;
        }

        return $sorting;
    }
}
