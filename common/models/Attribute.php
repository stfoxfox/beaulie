<?php

namespace common\models;

use Yii;
use common\models\gii\BaseAttribute
;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "attribute".
*/
class Attribute extends BaseAttribute
{
    const ICONS = [
        'images/attribute_icons/1.svg' => 'Экологическая безопасность',
        'images/attribute_icons/2.svg' => 'Лёгкость уборки',
        'images/attribute_icons/3.svg' => 'Применимость с системами подогрева пола до +27°C',
        'images/attribute_icons/4.svg' => 'Влагостойкость',
        'images/attribute_icons/5.svg' => 'Антибактериальность',
        'images/attribute_icons/6.svg' => 'Защитный PU лак',
        'images/attribute_icons/7.svg' => 'Устойчивость к воздействию мебели на роликовых ножках',
        'images/attribute_icons/8.svg' => 'Антистатичность',
        'images/attribute_icons/9.svg' => 'Стойкость к перепаду температур',
        'images/attribute_icons/10.svg' => 'Живая структура',
        'images/attribute_icons/11.svg' => 'Класс пожарной безопасности',
        'images/attribute_icons/12.svg' => 'Фаска 2V (двухсторонняя)',
        'images/attribute_icons/13.svg' => 'Фаска 4V (четырёхсторонняя)',
        'images/attribute_icons/14.svg' => 'Лак (обычный)',
        'images/attribute_icons/15.svg' => 'Лак (WRT)',
        'images/attribute_icons/16.svg' => 'Масло',
        'images/attribute_icons/17.svg' => 'Не нуждается в поливе',
        'images/attribute_icons/18.svg' => 'Устойчивость к воздействию УФ лучей',
        'images/attribute_icons/19.svg' => 'Класс пожарной безопасности',
        'images/attribute_icons/20.svg' => 'Замковое соединение 5G',
        'images/attribute_icons/21.svg' => 'Замковое соединение 2G',
        'images/attribute_icons/22.svg' => 'Экстратолщина',
        'images/attribute_icons/23.svg' => 'Пожизненная гарантия на замковое соединение',
        'images/attribute_icons/24.svg' => 'Гидро плюс',
        'images/attribute_icons/25.svg' => 'Не нуждается в уходе',
        'images/attribute_icons/26.svg' => 'Замок Dream Click для LVT',
        'images/attribute_icons/27.svg' => 'Антистатик',

    ];

    /**
     * @return string
     */
    public function getTypeLabel()
    {
        $l = self::typeLabels();
        return isset($l[$this->type]) ? $l[$this->type] : 'Не определён';
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title_ru');
    }

    /**
     * @return array
     */
    public function getValuesList()
    {
        return ArrayHelper::map($this->attributeValues, 'id', 'title_ru');
    }

    /**
     * @return array
     */
    public function getValuesListForEditable()
    {
        $result = [];
        foreach ($this->getValuesList() as $status => $label) {
            $result[] = ['value' => $status, 'text' => $label];
        }

        return $result;
    }

    /**
     * @param CatalogItem $item
     * @param string $lang
     * @return mixed
     */
    public function getValueFor($item, $lang = 'ru')
    {
        switch ($this->type) {
            case self::TYPE_STRING:
            case self::TYPE_NUMBER:
                return $this->getDb()->createCommand('SELECT string_value_'.$lang.' FROM catalog_item_attribute WHERE attribute_id=:attr AND catalog_item_id=:cid',[
                    ':attr' => $this->id,
                    ':cid' => $item->id
                ])->queryScalar();
                break;

            case self::TYPE_BOOL:
                $val = $this->getDb()->createCommand('SELECT bool_value FROM catalog_item_attribute WHERE attribute_id=:attr AND catalog_item_id=:cid',[
                    ':attr' => $this->id,
                    ':cid' => $item->id
                ])->queryScalar();
                return boolval($val) ? Yii::t('app.attribute.boolean', 'да') : Yii::t('app.attribute.boolean', 'нет');
                break;

            case self::TYPE_SELECT:
                return $this->getDb()->createCommand('SELECT title_'.$lang.' FROM attribute_value WHERE id IN (SELECT attribute_value_id FROM catalog_item_attribute WHERE attribute_id=:attr AND catalog_item_id=:cid)',[
                    ':attr' => $this->id,
                    ':cid' => $item->id
                ])->queryScalar();
                break;
        }

        return '';
    }

    /**
     * @return array
     */
    public function getViewType()
    {
        switch ($this->type) {
            case self::TYPE_SELECT:
            case self::TYPE_STRING:
                return [
                    CatalogCategoryFilter::VIEW_TYPE_CHECKBOX => 'Чекбокс',
                    CatalogCategoryFilter::VIEW_TYPE_SELECT => 'Селект',
                    CatalogCategoryFilter::VIEW_TYPE_RADIO => 'Радио',
                ];
            case self::TYPE_BOOL:
                return [
                    CatalogCategoryFilter::VIEW_TYPE_CHECKBOX => 'Чекбокс'
                ];
            case self::TYPE_NUMBER:
                return CatalogCategoryFilter::viewTypeLabels();
        }
    }
}
