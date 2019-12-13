<?php

namespace common\models\gii;

use common\models\Attribute;
use common\models\Brand;
use common\models\Collection;
use Yii;
use common\models\File;
use common\models\CatalogItemCategory;
use common\models\CatalogCategory;
use common\models\CatalogItemImage;
use yii\db\Query;


/**
 * This is the model class for table "catalog_item".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $file_id
 * @property string $ext_code
 * @property double $price
 * @property double $old_price
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property boolean $is_new
 * @property boolean $is_hit
 * @property boolean $is_home
 * @property boolean $is_sale
 * @property boolean $is_business
 *
 * @property integer $collection_id
 * @property integer $brand_id
 *
 * @property double $min_price
 * @property double $max_price
 *
 * @property File $file
 * @property CatalogItemCategory[] $catalogItemCategories
 * @property CatalogCategory[] $catalogCategories
 * @property CatalogItemImage[] $catalogItemImages
 * @property File[] $files
 * @property Collection $collection
 * @property Attribute[] $attributeModels
 * @property Brand $brand
 */
class BaseCatalogItem extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['file_id'], 'integer'],
            [['price', 'old_price', 'min_price', 'max_price'], 'number'],
            [['is_active', 'is_new', 'is_hit', 'is_home', 'is_sale', 'is_business'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'ext_code'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'file_id' => 'File ID',
            'ext_code' => 'Ext Code',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'is_active' => 'Is Active',
            'is_new' => 'Is New',
            'is_hit' => 'Is Hit',
            'is_home' => 'Is Home',
            'is_sale' => 'Is Sale',
            'is_business' => 'Is Business',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'collection_id' => 'Collection',
            'brand_id' => 'Brand',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
        ];
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
    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'catalog_category_id'])->viaTable('catalog_item_category', ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('catalog_item_image', ['catalog_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::className(), ['id' => 'collection_id']);
    }

    /**
     * @param mixed $condition
     * @return $this
     */
    public function getAttributeModels($condition = false)
    {
        $q = $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('catalog_item_attribute', ['catalog_item_id' => 'id']);
        if ($condition) {
            $q->andWhere($condition);
        }

        return $q;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}
