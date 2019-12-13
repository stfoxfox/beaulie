<?php

namespace backend\models\forms;

use common\components\MyExtensions\MyFileSystem;
use Yii;
use yii\base\Model;
use common\models\Tag;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
* This is the model class for BackendUser form.
*/
class TagForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title_ru' => 'Название'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title_ru', 'required'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by'], 'string']
        ];
    }

    /**
     * @param Tag $user
     * @return Tag|null
     */
    public function edit($tag)
    {
        if (!$this->validate()) {
            return null;
        }

        $tag->title_ru = $this->title_ru;
        $tag->title_en = $this->title_en;
        $tag->title_ua = $this->title_ua;
        $tag->title_kz = $this->title_kz;
        $tag->title_by = $this->title_by;

        if ($tag->save()) {
            return $tag;
        }

        return false;
    }

    public function loadFromItem($model = null)
    {
        if($model){
            $this->title_ru = $model->title_ru;
            $this->title_en = $model->title_en;
            $this->title_ua = $model->title_ua;
            $this->title_kz = $model->title_kz;
            $this->title_by = $model->title_by;
        }
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $tag = new Tag();
        
        $tag->title_ru = $this->title_ru;
        $tag->title_en = $this->title_en;
        $tag->title_ua = $this->title_ua;
        $tag->title_kz = $this->title_kz;
        $tag->title_by = $this->title_by;

        if ($tag->save()) {
            return $tag;
        }

        return false;
    }
}
