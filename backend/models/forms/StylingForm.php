<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Styling;
use common\models\Attribute;
use common\models\CatalogCategory;
use common\models\File;
use yii\web\UploadedFile;

/**
* This is the model class for Styling form.
*/
class StylingForm extends Model
{
    public $category_id;
    public $file_id;
    public $image_id;
    public $title_ru;
    public $title_en;
    public $title_kz;
    public $title_by;
    public $title_ua;
    public $subtitle_ru;
    public $subtitle_en;
    public $subtitle_kz;
    public $subtitle_by;
    public $subtitle_ua;
    public $text_ru;
    public $text_en;
    public $text_kz;
    public $text_by;
    public $text_ua;

    public $file;

    public $image;
    public $image_x;
    public $image_y;
    public $image_w;
    public $image_h;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'file_id', 'image_id'], 'integer'],
            [['title_ru', 'title_en', 'title_kz', 'title_by', 'title_ua'], 'string'],
            [['subtitle_ru', 'subtitle_en', 'subtitle_kz', 'subtitle_by', 'subtitle_ua'], 'string'],
            [['text_ru', 'text_en', 'text_kz', 'text_by', 'text_ua'], 'string'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['file'], 'file', 'extensions' => ['pdf'], 'maxFiles' => 1],
            [['image'], 'safe'],
            [['image_x', 'image_y', 'image_w', 'image_h'], 'number'],
        ];
    }

    /**
     * @param Styling $item
     */
    public function loadFromItem($item)
    {
        $this->category_id = $item->category_id;
        $this->file_id = $item->file_id;
        $this->image_id = $item->image_id;
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->title_ua = $item->title_ua;
        $this->subtitle_ru = $item->subtitle_ru;
        $this->subtitle_en = $item->subtitle_en;
        $this->subtitle_kz = $item->subtitle_kz;
        $this->subtitle_by = $item->subtitle_by;
        $this->subtitle_ua = $item->subtitle_ua;
        $this->text_ru = $item->text_ru;
        $this->text_en = $item->text_en;
        $this->text_kz = $item->text_kz;
        $this->text_by = $item->text_by;
        $this->text_ua = $item->text_ua;
    }

    /**
     * @inheritdoc
     * @var Styling $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->category_id = $this->category_id;
        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_kz = $this->title_kz;
        $item->title_ua = $this->title_ua;
        $item->title_by = $this->title_by;
        $item->subtitle_ru = $this->subtitle_ru;
        $item->subtitle_en = $this->subtitle_en;
        $item->subtitle_kz = $this->subtitle_kz;
        $item->subtitle_ua = $this->subtitle_ua;
        $item->subtitle_by = $this->subtitle_by;
        $item->text_ru = $this->text_ru;
        $item->text_en = $this->text_en;
        $item->text_kz = $this->text_kz;
        $item->text_by = $this->text_by;
        $item->text_ua = $this->text_ua;

        if($file = UploadedFile::getInstance($this, 'file')){
            $item->file_id = File::saveFile(
                $file, Styling::tableName(),
                $item->file_id
            );
        }

        if ($image = UploadedFile::getInstance($this,'image')) {
            $item->image_id = File::saveFile(
                $image, Styling::tableName(),
                $item->image_id,
                $this->image_x,
                $this->image_y,
                $this->image_h,
                $this->image_w
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

        $item = new Styling();

        $item->category_id = $this->category_id;
        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_kz = $this->title_kz;
        $item->title_ua = $this->title_ua;
        $item->title_by = $this->title_by;
        $item->subtitle_ru = $this->subtitle_ru;
        $item->subtitle_en = $this->subtitle_en;
        $item->subtitle_kz = $this->subtitle_kz;
        $item->subtitle_ua = $this->subtitle_ua;
        $item->subtitle_by = $this->subtitle_by;
        $item->text_ru = $this->text_ru;
        $item->text_en = $this->text_en;

        $item->category_id = $this->category_id;
        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->subtitle_ru = $this->subtitle_ru;
        $item->subtitle_en = $this->subtitle_en;
        $item->text_ru = $this->text_ru;
        $item->text_en = $this->text_en;
        $item->text_kz = $this->text_kz;
        $item->text_by = $this->text_by;
        $item->text_ua = $this->text_ua;

        if($file = UploadedFile::getInstance($this, 'file')){
            $item->file_id = File::saveFile(
                $file, Styling::tableName(),
                $item->file_id
            );
        }

        if ($image = UploadedFile::getInstance($this,'image')) {
            $item->image_id = File::saveFile(
                $image, Styling::tableName(),
                $item->image_id,
                $this->image_x,
                $this->image_y,
                $this->image_h,
                $this->image_w
            );
        }
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
