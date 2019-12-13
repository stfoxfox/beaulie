<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\CatalogCategoryFilterGroup;
use common\models\CatalogCategory;

/**
* This is the model class for CatalogCategoryFilterGroup form.
*/
class CatalogCategoryFilterGroupForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    public $catalog_category_id;
    public $sort;
    public $is_quick_filter;
    public $is_home;

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
     * @param CatalogCategoryFilterGroup $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->catalog_category_id = $item->catalog_category_id;
        $this->sort = $item->sort;
        $this->is_quick_filter = $item->is_quick_filter;
        $this->is_home = $item->is_home;
    }

    public function attributeLabels()
    {
        return [
            'catalog_category_id' => Yii::t('app.filter', 'Категория'),
            'is_quick_filter' => Yii::t('app.filter', 'Использовать в быстром фильтре'),
            'is_home' => 'Для дома'
        ];
    }

    /**
     * @inheritdoc
     * @var CatalogCategoryFilterGroup $item
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
        $item->catalog_category_id = $this->catalog_category_id;
        $item->sort = $this->sort;
        $item->is_quick_filter = $this->is_quick_filter;
        $item->is_home = $this->is_home;

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

        $item = new CatalogCategoryFilterGroup();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->catalog_category_id = $this->catalog_category_id;
        $item->sort = $this->sort;
        $item->is_quick_filter = $this->is_quick_filter;
        $item->is_home = $this->is_home;

        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
