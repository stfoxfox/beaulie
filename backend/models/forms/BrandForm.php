<?php

namespace backend\models\forms;

use common\models\File;
use Yii;
use yii\base\Model;
use common\models\Brand;
use yii\web\UploadedFile;
use common\components\MyExtensions\MyFileSystem;
use yii\helpers\Json;

/**
* This is the model class for Brand form.
*/
class BrandForm extends Model
{
    public $title_ru;
    public $about_ru;
    public $title_en;
    public $about_en;
    public $title_kz;
    public $about_kz;
    public $title_ua;
    public $about_ua;
    public $title_by;
    public $about_by;
    public $file_id;
    public $brand_file_id;
    public $file_name;
    public $brand_file_name;
    public $image;
    public $sort;
    public $tags;
    public $show_on_page;

    public function attributeLabels()
    {
        return [
            'show_on_page' => 'Показывать на странице брендов'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['about_ru', 'about_en', 'about_kz', 'about_ua', 'about_by'], 'string'],
            [['file_name', 'brand_file_name'], 'file', 'extensions' => ['jpg', 'png'], 'maxFiles' => 1],
            [['sort'], 'integer'],
            [['show_on_page'], 'boolean'],
            [['title_ru', 'title_en', 'title_kz', 'title_ua', 'title_by'], 'string', 'max' => 255],
            [['tags'], 'safe'],
        ];
    }

    /**
     * @param Brand $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->about_ru = $item->about_ru;
        $this->title_en = $item->title_en;
        $this->about_en = $item->about_en;
        $this->title_kz = $item->title_kz;
        $this->about_kz = $item->about_kz;
        $this->title_ua = $item->title_ua;
        $this->about_ua = $item->about_ua;
        $this->title_by = $item->title_by;
        $this->about_by = $item->about_by;
        $this->file_id = $item->file_id;
        $this->brand_file_id = $item->brand_file_id;
        $this->sort = $item->sort;
        $this->tags = Json::decode($item->tags);
        $this->show_on_page = $item->show_on_page;
    }

    /**
     * @inheritdoc
     * @var Brand $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title_ru = $this->title_ru;
        $item->about_ru = $this->about_ru;
        $item->title_en = $this->title_en;
        $item->about_en = $this->about_en;
        $item->title_kz = $this->title_kz;
        $item->about_kz = $this->about_kz;
        $item->title_ua = $this->title_ua;
        $item->about_ua = $this->about_ua;
        $item->title_by = $this->title_by;
        $item->about_by = $this->about_by;
        $item->sort = $this->sort;
        $item->show_on_page = $this->show_on_page;

        $item->tags = Json::encode($this->tags);

        if ($picture = UploadedFile::getInstance($this, 'file_name')) {
            $fileId = File::saveFile($picture, 'brand');
            if ($fileId) {
                $item->file_id = $fileId;
            }
        }

        if ($picture2 = UploadedFile::getInstance($this, 'brand_file_name')) {
            $fileId = File::saveFile($picture2, 'brand');
            if ($fileId) {
                $item->brand_file_id = $fileId;
            }
        }

        if ($item->save()) {

            return $item;
        }

        return null;
    }

    /**
     * @return Brand|null
     */
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new Brand();

        $item->title_ru = $this->title_ru;
        $item->about_ru = $this->about_ru;
        $item->title_en = $this->title_en;
        $item->about_en = $this->about_en;
        $item->title_kz = $this->title_kz;
        $item->about_kz = $this->about_kz;
        $item->title_ua = $this->title_ua;
        $item->about_ua = $this->about_ua;
        $item->title_by = $this->title_by;
        $item->about_by = $this->about_by;
        $item->sort = $this->sort;
        $item->tags = Json::encode($this->tags);
        $item->show_on_page = $this->show_on_page;

        if ($picture = UploadedFile::getInstance($this, 'file_name')) {
            $fileId = File::saveFile($picture, 'brand');
            if ($fileId) {
                $item->file_id = $fileId;
            }
        }

        if ($picture2 = UploadedFile::getInstance($this, 'brand_file_name')) {
            $fileId = File::saveFile($picture2, 'brand');
            if ($fileId) {
                $item->brand_file_id = $fileId;
            }
        }

        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
