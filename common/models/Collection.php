<?php

namespace common\models;

use Yii;
use common\models\gii\BaseCollection
;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "collection".
*/
class Collection extends BaseCollection
{
    public static function getItemsForSelect($condition = [])
    {
        $q = self::find();
        if ($condition) $q->andWhere($condition);
        return ArrayHelper::map($q->all(), 'id', 'title_ru');
    }

    public function getCatalogItems()
    {
        return $this->hasMany(CatalogItem::className(), ['collection_id' => 'id']);
    }

    protected function notShownAttributeValues()
    {
        return [
            '',
            'нет'
        ];
    }

    /**
     * @param int $category_id
     * @param array|string $condition
     * @return array
     */
    public function getCategoryAttributesAsArray($category_id, $condition = [])
    {
        $attributes = [];
        $models = CatalogItem::getCategoryAttributes($category_id, $condition);

        foreach ($this->catalogItems as $item) {
            /* @var $item CatalogItem */
            foreach ($models as $attributeModel) {
                /* @var Attribute $attributeModel */
                $attributes[$attributeModel->id]['title'] = $attributeModel->title;
                $attributes[$attributeModel->id]['standard'] = $attributeModel->standard;
                $value = $attributeModel->getValueFor($item, Language::current());

                if (!isset($attributes[$attributeModel->id]['values'])) {
                    $attributes[$attributeModel->id]['values'] = [];
                }

                if (
                    !in_array($value, $attributes[$attributeModel->id]['values']) &&
                    !in_array(mb_strtolower($value), $this->notShownAttributeValues())
                ) {
                    $attributes[$attributeModel->id]['values'][] = $value;
                }

                $attributes[$attributeModel->id]['type'] = $attributeModel->type;
                $attributes[$attributeModel->id]['measure'] = $attributeModel->measure;
                if ($attributeModel->icon_type && !in_array(mb_strtolower($value), $this->notShownAttributeValues())) {
                    $attributes[$attributeModel->id]['icon_path'] = $attributeModel->icon_type;
                    $attributes[$attributeModel->id]['icon_label'] = Attribute::ICONS[$attributeModel->icon_type];
                }

            }
        }

        foreach ($attributes as $key => $attribute) {
            if (empty($attribute['values']) || empty($attribute['values'][0])) {
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
