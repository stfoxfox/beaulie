<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\News;
use common\models\File;
use common\models\Tag;
use common\models\Page;
use common\models\CatalogCategory;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
* This is the model class for News form.
*/
class NewsForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_kz;
    public $title_ua;
    public $title_by;

    public $text_ru;
    public $text_en;
    public $text_kz;
    public $text_ua;
    public $text_by;

    public $file_id;
    public $file;

    public $file_x;
    public $file_y;
    public $file_w;
    public $file_h;
    public $tags;
    public $catalog_categories;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['file', 'title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by',], 'string', 'max' => 255],
            [['text_ru', 'text_en', 'text_ua', 'text_kz', 'text_by',], 'string'],
            [['file_id'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['file_name_x','file_name_y','file_name_w','file_name_h'], 'safe'],
            
            [['file'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],
            [['created_at', 'updated_at', 'tags', 'catalog_categories'], 'safe'],
        ];
    }
    

    /**
     * @param Page $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;

        $this->text_ru = $item->text_ru;
        $this->text_en = $item->text_en;
        $this->text_ua = $item->text_ua;
        $this->text_kz = $item->text_kz;
        $this->text_by = $item->text_by;

        $this->file_id = $item->file_id;

        $this->tags = ArrayHelper::getColumn($item->getTags()->asArray()->all(), 'id');
        $this->catalog_categories = ArrayHelper::getColumn($item->getCatalogCategories()->asArray()->all(), 'id');
    }

    /**
     * @inheritdoc
     * @var Page $item
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

        $item->text_ru = $this->text_ru;
        $item->text_en = $this->text_en;
        $item->text_ua = $this->text_ua;
        $item->text_kz = $this->text_kz;
        $item->text_by = $this->text_by;

        if ($file = UploadedFile::getInstance($this,'file')) {
            $item->file_id = File::saveFile(
                $file, News::tableName(),
                $item->file_id,
                $this->file_x,
                $this->file_y,
                $this->file_h,
                $this->file_w
            );
        }

        if ($item->save()) {
            $item->unlinkAll('tags', true);                    
            if(!empty($this->tags)){
                foreach($this->tags as $key => $value){
                    $item->link('tags', Tag::findOne($value));
                }
            }            

            $item->unlinkAll('catalogCategories', true);                    
            if(!empty($this->catalog_categories)){
                foreach($this->catalog_categories as $key => $value){
                    $item->link('catalogCategories', CatalogCategory::findOne($value));
                }
            }

            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new News();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;

        $item->text_ru = $this->text_ru;
        $item->text_en = $this->text_en;
        $item->text_ua = $this->text_ua;
        $item->text_kz = $this->text_kz;
        $item->text_by = $this->text_by;

        $page= new Page();
        $page->is_internal = true;
        $page->title_ru = $item->title;
        $page->slug = "no";
        $page->save();

        $item->page_id = $page->id;

        if ($file = UploadedFile::getInstance($this,'file')) {
            $item->file_id= File::saveFile(
                $file, News::tableName(),
                $item->file_id,
                $this->file_x,
                $this->file_y,
                $this->file_h,
                $this->file_w
            );
        }
    
        if ($item->save()) {
            
            if(!empty($this->tags)){
                foreach($this->tags as $key => $value){
                    $item->link('tags', Tag::findOne($value));
                }
            }            

            if(!empty($this->catalog_categories)){
                foreach($this->catalog_categories as $key => $value){
                    $item->link('catalogCategories', CatalogCategory::findOne($value));
                }
            }

            

            return $item;
        }

        return null;
    }
}
