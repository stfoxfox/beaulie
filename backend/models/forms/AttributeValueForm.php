<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\AttributeValue;
use common\models\Attribute;

/**
* This is the model class for AttributeValue form.
*/
class AttributeValueForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    public $attribute_id;
    public $ext_key;
    public $sort;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['attribute_id', 'sort'], 'integer'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'ext_key'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    /**
     * @param AttributeValue $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->attribute_id = $item->attribute_id;
        $this->ext_key = $item->ext_key;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var AttributeValue $item
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
        $item->attribute_id = $this->attribute_id;
        $item->ext_key = $this->ext_key;
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

        $item = new AttributeValue();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->attribute_id = $this->attribute_id;
        $item->ext_key = $this->ext_key;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
