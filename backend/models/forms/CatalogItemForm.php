<?php

namespace backend\models\forms;

use common\models\CatalogCategory;
use common\models\File;
use Yii;
use yii\base\Model;
use common\models\CatalogItem;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\Brand;

/**
* This is the model class for CatalogItem form.
*/
class CatalogItemForm extends Model
{
    public $title;
    public $description;
    public $file_id;
    public $file_name;
    public $ext_code;
    public $price;
    public $old_price;
    public $min_price;
    public $max_price;
    public $is_active;
    public $is_new;
    public $is_hit;
    public $is_home;
    public $is_sale;
    public $is_business;
    public $parent_id;

    public $collection_id;
    public $brand_id;

    public $categories;

    public $file_name_x;
    public $file_name_y;
    public $file_name_w;
    public $file_name_h;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categories'], 'required'],
            [['description'], 'string'],
            [['file_id', 'collection_id'], 'integer'],
            [['price', 'old_price', 'min_price', 'max_price'], 'number'],
            [['is_active', 'is_new', 'is_hit', 'is_home', 'is_sale', 'is_business'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'ext_code'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],

            [['file_name_x','file_name_y','file_name_w','file_name_h'], 'safe'],

            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],
        ];
    }

    /**
     * @param CatalogItem $item
     */
    public function loadFromItem($item)
    {
        $this->title = $item->title;
        $this->description = $item->description;
        $this->file_id = $item->file_id;
        $this->ext_code = $item->ext_code;
        $this->price = $item->price;
        $this->old_price = $item->old_price;
        $this->is_active = $item->is_active;
        $this->is_new = $item->is_new;
        $this->is_hit = $item->is_hit;
        $this->is_home = $item->is_home;
        $this->is_sale = $item->is_sale;
        $this->is_business = $item->is_business;
        $this->collection_id = $item->collection_id;
        $this->brand_id = $item->brand_id;
        $this->min_price = $item->min_price;
        $this->max_price = $item->max_price;


        $this->categories=ArrayHelper::getColumn($item->getCatalogCategories()->asArray()->all(), 'id');
    }

    /**
     * @inheritdoc
     * @var CatalogItem $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->description = $this->description;
        $item->ext_code = $this->ext_code;
        $item->price = $this->price;
        $item->old_price = $this->old_price;
        $item->is_active = $this->is_active;
        $item->is_new = $this->is_new;
        $item->is_hit = $this->is_hit;
        $item->is_home = $this->is_home;
        $item->is_sale = $this->is_sale;
        $item->is_business = $this->is_business;
        $item->collection_id = $this->collection_id;
        $item->brand_id = $this->brand_id;
        $item->min_price = $this->min_price;
        $item->max_price = $this->max_price;


        if($picture =UploadedFile::getInstance($this,'file_name')) {
            $item->file_id= File::saveFile($picture,CatalogItem::tableName(),$item->file_id,$this->file_name_x,$this->file_name_y,$this->file_name_h,$this->file_name_w);
        }

        $old_sort_order = (new Query())->select(['catalog_category_id','sort'])->where(['catalog_item_id'=>$item->id])->from('catalog_item_category')->all();
        $old_sort_order_array = ArrayHelper::map($old_sort_order,'catalog_category_id','sort');

        $item->unlinkAll('catalogCategories', true);

        $categories = CatalogCategory::find()->where(['in', 'id', $this->categories])->all();
        foreach ($categories as $category) {
            $sort = ArrayHelper::getValue($old_sort_order_array,$category->id,false)?ArrayHelper::getValue($old_sort_order_array,$category->id,false):0;
            $item->link('catalogCategories', $category,['sort'=>$sort]);
        }

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

        $item = new CatalogItem();

        $item->title = $this->title;
        $item->description = $this->description;
        $item->ext_code = $this->ext_code;
        $item->price = $this->price;
        $item->old_price = $this->old_price;
        $item->is_active = $this->is_active;
        $item->is_new = $this->is_new;
        $item->is_hit = $this->is_hit;
        $item->is_home = $this->is_home;
        $item->is_sale = $this->is_sale;
        $item->is_business = $this->is_business;
        $item->collection_id = $this->collection_id;
        $item->brand_id = $this->brand_id;
        $item->min_price = $this->min_price;
        $item->max_price = $this->max_price;


        if($picture =UploadedFile::getInstance($this,'file_name')) {
            $item->file_id= File::saveFile($picture,CatalogItem::tableName(),$item->file_id,$this->file_name_x,$this->file_name_y,$this->file_name_h,$this->file_name_w);
        }

        if ($item->save()) {
            foreach ($this->categories as $category){
                $category_item = CatalogCategory::findOne($category);
                if ($category_item){
                    $category_item->link('catalogItems',$item,['sort'=>0]);
                }
            }

            return $item;
        }

        return null;
    }
}
