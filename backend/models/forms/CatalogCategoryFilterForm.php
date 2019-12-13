<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\CatalogCategoryFilter;
use common\models\Attribute;
use common\models\CatalogCategory;
use common\models\CatalogCategoryFilterGroup;

/**
* This is the model class for CatalogCategoryFilter form.
*/
class CatalogCategoryFilterForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    public $catalog_category_filter_group_id;
    public $catalog_category_id;
    public $attribute_id;
    public $type;
    public $view_type;
    public $sort;

    public function attributeLabels()
    {
        return [
            'type' => 'Тип',
            'view_type' => 'Тип отображения',
            'attribute_id' => 'Атрибут'
        ];
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
     * @param CatalogCategoryFilter $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->catalog_category_filter_group_id = $item->catalog_category_filter_group_id;
        $this->catalog_category_id = $item->catalog_category_id;
        $this->attribute_id = $item->attribute_id;
        $this->type = $item->type;
        $this->view_type = $item->view_type;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var CatalogCategoryFilter $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->catalog_category_filter_group_id = $this->catalog_category_filter_group_id;
        $item->catalog_category_id = $this->catalog_category_id;

        $item->type = $this->type;
        if ((int) $item->type === CatalogCategoryFilter::TYPE_ATTR) {
            $item->attribute_id = $this->attribute_id;
        } else {
            $item->attribute_id = null;
        }

        $item->view_type = $this->view_type;
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

        $item = new CatalogCategoryFilter();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->catalog_category_filter_group_id = $this->catalog_category_filter_group_id;
        $item->catalog_category_id = $this->catalog_category_id;

        $item->type = $this->type;
        if ((int) $item->type === CatalogCategoryFilter::TYPE_ATTR) {
            $item->attribute_id = $this->attribute_id;
        } else {
            $item->attribute_id = null;
        }

        $item->view_type = $this->view_type;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
