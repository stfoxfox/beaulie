<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Attribute;
/**
* This is the model class for Attribute form.
*/
class AttributeForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    
    public $standard_ru;
    public $standard_en;
    public $standard_ua;
    public $standard_kz;
    public $standard_by;

    public $ext_key;
    public $icon_type;
    public $measure;
    public $type;
    public $sort;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['type', 'sort'], 'integer'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'ext_key', 'icon_type', 'measure'], 'string', 'max' => 255],
            [['standard_ru', 'standard_en', 'standard_ua', 'standard_kz', 'standard_by'], 'string', 'max' => 255]
        ];
    }

    /**
     * @param Attribute $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;

        $this->standard_ru = $item->standard_ru;
        $this->standard_en = $item->standard_en;
        $this->standard_ua = $item->standard_ua;
        $this->standard_kz = $item->standard_kz;
        $this->standard_by = $item->standard_by;

        $this->ext_key = $item->ext_key;
        $this->icon_type = $item->icon_type;
        $this->measure = $item->measure;
        $this->type = $item->type;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var Attribute $item
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

        $item->standard_ru = $this->standard_ru;
        $item->standard_en = $this->standard_en;
        $item->standard_ua = $this->standard_ua;
        $item->standard_kz = $this->standard_kz;
        $item->standard_by = $this->standard_by;

        $item->ext_key = $this->ext_key;
        $item->icon_type = $this->icon_type;
        $item->measure = $this->measure;
        $item->type = $this->type;
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

        $item = new Attribute();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;

        $item->standard_ru = $this->standard_ru;
        $item->standard_en = $this->standard_en;
        $item->standard_ua = $this->standard_ua;
        $item->standard_kz = $this->standard_kz;
        $item->standard_by = $this->standard_by;

        $item->ext_key = $this->ext_key;
        $item->icon_type = $this->icon_type;
        $item->measure = $this->measure;
        $item->type = $this->type;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'measure' => 'Единица измерения'
        ];
    }
}
