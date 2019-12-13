<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Page;
use common\models\File;
use yii\web\UploadedFile;

/**
* This is the model class for Page form.
*/
class PageForm extends Model
{
    public $slug;
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    public $description_ru;
    public $description_en;
    public $description_ua;
    public $description_kz;
    public $description_by;
    public $html_text_ru;
    public $html_text_en;
    public $html_text_ua;
    public $html_text_kz;
    public $html_text_by;
    public $is_index_page=false;
    public $is_internal=false;
    public $banner_color;
    public $banner_file_id;
    public $file_name;
    public $file_name_x;
    public $file_name_y;
    public $file_name_w;
    public $file_name_h;
    public $banner_text_ru;
    public $banner_text_en;
    public $banner_text_ua;
    public $banner_text_kz;
    public $banner_text_by;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title_ru'], 'required'],
            [['html_text_ru', 'html_text_en', 'html_text_ua', 'html_text_kz', 'html_text_by', 'banner_text_ru', 'banner_text_en', 'banner_text_ua', 'banner_text_kz', 'banner_text_by'], 'string'],

            [['banner_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['banner_file_id' => 'id']],
            [['file_name_x','file_name_y','file_name_w','file_name_h'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],

            [['is_index_page', 'is_internal'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'description_ru', 'description_en', 'description_ua', 'description_kz', 'description_by', 'banner_color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param Page $item
     */
    public function loadFromItem($item)
    {
        $this->slug = $item->slug;
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->description_ru = $item->description_ru;
        $this->description_en = $item->description_en;
        $this->description_ua = $item->description_ua;
        $this->description_kz = $item->description_kz;
        $this->description_by = $item->description_by;
        $this->html_text_ru = $item->html_text_ru;
        $this->html_text_en = $item->html_text_en;
        $this->html_text_ua = $item->html_text_ua;
        $this->html_text_kz = $item->html_text_kz;
        $this->html_text_by = $item->html_text_by;
        $this->is_index_page = $item->is_index_page;
        $this->is_internal = $item->is_internal;
        $this->banner_color = $item->banner_color;
        $this->banner_file_id = $item->banner_file_id;
        $this->banner_text_ru = $item->banner_text_ru;
        $this->banner_text_en = $item->banner_text_en;
        $this->banner_text_ua = $item->banner_text_ua;
        $this->banner_text_kz = $item->banner_text_kz;
        $this->banner_text_by = $item->banner_text_by;
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

        $item->slug = $this->slug;
        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->description_ru = $this->description_ru;
        $item->description_en = $this->description_en;
        $item->description_ua = $this->description_ua;
        $item->description_kz = $this->description_kz;
        $item->description_by = $this->description_by;
        $item->html_text_ru = $this->html_text_ru;
        $item->html_text_en = $this->html_text_en;
        $item->html_text_ua = $this->html_text_ua;
        $item->html_text_kz = $this->html_text_kz;
        $item->html_text_by = $this->html_text_by;
        $item->is_index_page = $this->is_index_page;
        $item->is_internal = $this->is_internal;
        $item->banner_text_ru = $this->banner_text_ru;
        $item->banner_text_en = $this->banner_text_en;
        $item->banner_text_ua = $this->banner_text_ua;
        $item->banner_text_kz = $this->banner_text_kz;
        $item->banner_text_by = $this->banner_text_by;
        $item->banner_color = $this->banner_color;

        if ($picture = UploadedFile::getInstance($this,'file_name')) {
            $item->banner_file_id = File::saveFile(
                $picture, Page::tableName(),
                $item->banner_file_id,
                $this->file_name_x,
                $this->file_name_y,
                $this->file_name_h,
                $this->file_name_w
            );
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

        $item = new Page();

        $item->slug = $this->slug;
        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->description_ru = $this->description_ru;
        $item->description_en = $this->description_en;
        $item->description_ua = $this->description_ua;
        $item->description_kz = $this->description_kz;
        $item->description_by = $this->description_by;
        $item->html_text_ru = $this->html_text_ru;
        $item->html_text_en = $this->html_text_en;
        $item->html_text_ua = $this->html_text_ua;
        $item->html_text_kz = $this->html_text_kz;
        $item->html_text_by = $this->html_text_by;
        $item->is_index_page = $this->is_index_page;
        $item->is_internal = $this->is_internal;
        $item->banner_text_ru = $this->banner_text_ru;
        $item->banner_text_en = $this->banner_text_en;
        $item->banner_text_ua = $this->banner_text_ua;
        $item->banner_text_kz = $this->banner_text_kz;
        $item->banner_text_by = $this->banner_text_by;
        $item->banner_color = $this->banner_color;

        if ($picture = UploadedFile::getInstance($this,'file_name')) {
            $item->banner_file_id= File::saveFile(
                $picture, Page::tableName(),
                null,
                $this->file_name_x,
                $this->file_name_y,
                $this->file_name_h,
                $this->file_name_w
            );
        }
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
