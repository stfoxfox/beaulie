<?php

namespace common\models\gii;

use Yii;
use common\models\Attribute;
use common\models\CatalogCategory;


/**
 * This is the model class for table "catalog_category_attribute".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $attribute_id
 * @property boolean $show_in_collection
 * @property boolean $show_in_list
 * @property boolean $show_in_catalog_item
 * @property boolean $show_collection_icon
 * @property integer $sort
 *
 * @property Attribute $attributeModel
 * @property CatalogCategory $category
 */
class BaseCatalogCategoryAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'attribute_id', 'sort'], 'integer'],
            [['show_in_collection', 'show_in_list', 'show_in_catalog_item', 'show_collection_icon'], 'boolean'],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'show_in_collection' => Yii::t('app', 'Show In Collection'),
            'show_in_list' => Yii::t('app', 'Show In List'),
            'show_in_catalog_item' => Yii::t('app', 'Show In Catalog Item'),
            'show_collection_icon' => Yii::t('app', 'Show Collection Icon'),
            'sort' => Yii::t('app', 'Sort'),
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
    public function getCategory()
    {
        return $this->hasOne(CatalogCategory::className(), ['id' => 'category_id']);
    }
}
