<?php

namespace common\models\gii;

use common\models\Attribute;
use Yii;
use common\models\CatalogCategoryFilter;
use common\models\CatalogCategory;


/**
 * This is the model class for table "catalog_category_filter_group".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property integer $catalog_category_id
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $is_quick_filter
 * @property boolean $is_home
 *
 * @property CatalogCategoryFilter[] $catalogCategoryFilters
 * @property CatalogCategory $catalogCategory
 */
class BaseCatalogCategoryFilterGroup extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category_filter_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_category_id', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_quick_filter', 'is_home'], 'boolean'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by'], 'string', 'max' => 255],
            [['catalog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['catalog_category_id' => 'id']],
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
            'catalog_category_id' => 'Catalog Category ID',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_quick_filter' => 'Is Quick Filter',
            'is_home' => 'Is Home'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategoryFilters()
    {
        return $this->hasMany(CatalogCategoryFilter::className(), ['catalog_category_filter_group_id' => 'id']);
    }

    public function getMainCatalogCategoryFilters()
    {
        return $this->getCatalogCategoryFilters()->leftJoin('attribute', 'catalog_category_filter.attribute_id=attribute.id')
            ->where('catalog_category_filter.type != ' . CatalogCategoryFilter::TYPE_ATTR . ' OR attribute.type != ' .Attribute::TYPE_BOOL );
    }

    public function getBooleanCatalogCategoryFilters()
    {
        return $this->hasMany(CatalogCategoryFilter::className(), ['catalog_category_filter_group_id' => 'id'])
            ->leftJoin('attribute', 'catalog_category_filter.attribute_id=attribute.id')
            ->where(['attribute.type' => Attribute::TYPE_BOOL]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategory()
    {
        return $this->hasOne(CatalogCategory::className(), ['id' => 'catalog_category_id']);
    }
}
