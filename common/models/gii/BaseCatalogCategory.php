<?php

namespace common\models\gii;

use common\models\CatalogCategoryFilterGroup;
use Yii;
use common\models\CatalogCategory;
use common\models\File;
use common\models\CatalogItemCategory;
use common\models\CatalogItem;
use common\models\CatalogCategoryAttribute;
use common\models\Styling;

/**
 * This is the model class for table "catalog_category".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $description_ru
 * @property string $business_description_ru
 * @property string $title_en
 * @property string $description_en
 * @property string $business_description_en
 * @property string $title_ua
 * @property string $description_ua
 * @property string $business_description_ua
 * @property string $title_kz
 * @property string $description_kz
 * @property string $business_description_kz
 * @property string $title_by
 * @property string $description_by
 * @property string $business_description_by
 * @property integer $parent_catalog_category_id
 * @property integer $file_id
 * @property integer $sort
 * @property boolean $show_in_app
 * @property string $created_at
 * @property string $updated_at
 * @property integer $business_file_id
 * @property string $business_color
 * @property string $home_color
 *
 * @property CatalogCategory $parentCatalogCategory
 * @property CatalogCategory[] $catalogCategories
 * @property File $file
 * @property File $businessFile
 * @property CatalogItem[] $catalogItems
 * @property CatalogCategoryFilterGroup[] $filterGroups
 * @property CatalogCategoryAttribute[] $categoryAttributes
 */
class BaseCatalogCategory extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description_ru', 'description_en', 'description_ua', 'description_kz', 'description_by', 'business_description_ru', 'business_description_en', 'business_description_ua', 'business_description_kz', 'business_description_by'], 'string'],
            [['parent_catalog_category_id', 'file_id', 'sort'], 'integer'],
            [['show_in_app'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'business_color', 'home_color'], 'string', 'max' => 255],
            [['parent_catalog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['parent_catalog_category_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['business_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['business_file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Title',
            'description_ru' => 'Description',
            'business_description_ru' => 'Description',
            'title_en' => 'Title',
            'description_en' => 'Description',
            'business_description_en' => 'Description',
            'title_ua' => 'Title',
            'description_ua' => 'Description',
            'business_description_ua' => 'Description',
            'title_kz' => 'Title',
            'description_kz' => 'Description',
            'business_description_kz' => 'Description',
            'title_by' => 'Title',
            'description_by' => 'Description',
            'business_description_by' => 'Description',
            'parent_catalog_category_id' => 'Parent Catalog Category ID',
            'file_id' => 'File ID',
            'business_file_id' => 'Business File ID',
            'sort' => 'Sort',
            'show_in_app' => 'Show In App',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'business_color' => 'Business Color',
            'home_color' => 'Home Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCatalogCategory()
    {
        return $this->hasOne(CatalogCategory::className(), ['id' => 'parent_catalog_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategory::className(), ['parent_catalog_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessFile()
    {
        return $this->hasOne(File::className(), ['id' => 'business_file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItems()
    {
        return $this->hasMany(CatalogItem::className(), ['id' => 'catalog_item_id'])->viaTable('catalog_item_category', ['catalog_category_id' => 'id']);
    }

    public function getFilterGroups()
    {
        return $this->hasMany(CatalogCategoryFilterGroup::className(), ['catalog_category_id' => 'id']);
    }

    public function getCategoryAttributes()
    {
        return $this->hasMany(CatalogCategoryAttribute::className(), ['category_id' => 'id']);
    }

    public function getStylings(){
        return $this->hasMany(Styling::className(), ['category_id' => 'id']);
    }
}
