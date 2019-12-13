<?php

namespace common\models\gii;

use Yii;
use common\models\Attribute;
use common\models\CatalogCategory;
use common\models\CatalogCategoryFilterGroup;


/**
 * This is the model class for table "catalog_category_filter".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property integer $catalog_category_filter_group_id
 * @property integer $catalog_category_id
 * @property integer $attribute_id
 * @property integer $type
 * @property integer $view_type
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attribute $attributeModel
 * @property CatalogCategory $catalogCategory
 * @property CatalogCategoryFilterGroup $catalogCategoryFilterGroup
 */
class BaseCatalogCategoryFilter extends \common\components\MyExtensions\MyActiveRecord
{
    const TYPE_PRICE = 10;
    const TYPE_BRAND = 20;
    const TYPE_COLLECTION = 30;
    const TYPE_ATTR = 40;

    /**
     * @return array
     */
    public static function typeLabels()
    {
        return [
            self::TYPE_PRICE => 'Цена',
            self::TYPE_BRAND => 'Бренд',
            self::TYPE_COLLECTION => 'Коллекция',
            self::TYPE_ATTR => 'Атрибут'
        ];
    }

    /**
     * @return string
     */
    public function getTypeLabel()
    {
        $l = self::typeLabels();
        return isset($l[$this->type]) ? $l[$this->type] : 'Не определён';
    }

    /**
     * @param $type
     * @return array
     */
    public static function getViewType($type) {
        $types = [
            self::TYPE_PRICE => [
                self::VIEW_TYPE_RANGE => 'Диапазон',
                self::VIEW_TYPE_SELECT_RANGE => 'Чекбоксы диапазонов'
            ],
            self::TYPE_BRAND => [
                self::VIEW_TYPE_CHECKBOX => 'Чекбокс',
                self::VIEW_TYPE_RADIO => 'Радио',
                self::VIEW_TYPE_SELECT => 'Селект',
            ],
            self::TYPE_COLLECTION => [
                self::VIEW_TYPE_CHECKBOX => 'Чекбокс',
                self::VIEW_TYPE_RADIO => 'Радио',
                self::VIEW_TYPE_SELECT => 'Селект',
            ],
            self::TYPE_ATTR => [
                self::VIEW_TYPE_CHECKBOX => 'Чекбокс',
                self::VIEW_TYPE_RADIO => 'Радио',
                self::VIEW_TYPE_SELECT => 'Селект',
                self::VIEW_TYPE_SELECT_RANGE => 'Чекбоксы диапазонов'
            ]
        ];

        return isset($types[$type]) ? $types[$type] : [];
    }

    const VIEW_TYPE_CHECKBOX = 10;
    const VIEW_TYPE_SELECT = 20;
    const VIEW_TYPE_RADIO = 30;
    const VIEW_TYPE_RANGE = 40;
    const VIEW_TYPE_SELECT_RANGE = 50;

    /**
     * @return array
     */
    public static function viewTypeLabels()
    {
        return [
            self::VIEW_TYPE_CHECKBOX => 'Чекбокс',
            self::VIEW_TYPE_SELECT => 'Селект',
            self::VIEW_TYPE_RADIO => 'Радио',
            self::VIEW_TYPE_RANGE => 'Диапазон',
            self::VIEW_TYPE_SELECT_RANGE => 'Чекбоксы диапазонов',
        ];
    }

    /**
     * @return string
     */
    public function getViewTypeLabel()
    {
        $l = self::viewTypeLabels();
        return isset($l[$this->view_type]) ? $l[$this->view_type] : 'Не определён';
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_category_filter_group_id', 'catalog_category_id', 'attribute_id', 'type', 'view_type', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['catalog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['catalog_category_id' => 'id']],
            [['catalog_category_filter_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategoryFilterGroup::className(), 'targetAttribute' => ['catalog_category_filter_group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Title Ru',
            'title_en' => 'Title En',
            'title_ua' => 'Title Ua',
            'title_kz' => 'Title Kz',
            'title_by' => 'Title By',
            'catalog_category_filter_group_id' => 'Catalog Category Filter Group ID',
            'catalog_category_id' => 'Catalog Category ID',
            'attribute_id' => 'Attribute ID',
            'type' => 'Type',
            'view_type' => 'View Type',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeModel()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategory()
    {
        return $this->hasOne(CatalogCategory::className(), ['id' => 'catalog_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategoryFilterGroup()
    {
        return $this->hasOne(CatalogCategoryFilterGroup::className(), ['id' => 'catalog_category_filter_group_id']);
    }
}
