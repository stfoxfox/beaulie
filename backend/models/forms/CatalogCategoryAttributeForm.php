<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\CatalogCategoryAttribute;
use common\models\Attribute;
use common\models\CatalogCategory;

/**
* This is the model class for CatalogCategoryAttribute form.
*/
class CatalogCategoryAttributeForm extends Model
{
    public $category_id;
    public $attribute_id;
    public $show_in_collection;
    public $show_in_list;
    public $show_in_catalog_item;
    public $show_collection_icon;
    public $sort;

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
     * @param CatalogCategoryAttribute $item
     */
    public function loadFromItem($item)
    {
        $this->category_id = $item->category_id;
        $this->attribute_id = $item->attribute_id;
        $this->show_in_collection = $item->show_in_collection;
        $this->show_in_list = $item->show_in_list;
        $this->show_in_catalog_item = $item->show_in_catalog_item;
        $this->show_collection_icon = $item->show_collection_icon;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var CatalogCategoryAttribute $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->category_id = $this->category_id;
        $item->attribute_id = $this->attribute_id;
        $item->show_in_collection = $this->show_in_collection;
        $item->show_in_list = $this->show_in_list;
        $item->show_in_catalog_item = $this->show_in_catalog_item;
        $item->show_collection_icon = $this->show_collection_icon;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new CatalogCategoryAttribute();

        $item->category_id = $this->category_id;
        $item->attribute_id = $this->attribute_id;
        $item->show_in_collection = $this->show_in_collection;
        $item->show_in_list = $this->show_in_list;
        $item->show_in_catalog_item = $this->show_in_catalog_item;
        $item->show_collection_icon = $this->show_collection_icon;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
