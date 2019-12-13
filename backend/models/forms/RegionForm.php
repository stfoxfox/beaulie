<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Region;
/**
* This is the model class for Region form.
*/
class RegionForm extends Model
{
    public $title;
    public $sort;
    public $is_default;
    public $popup;
    public $country_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'country_id'], 'integer'],
            [['is_default', 'popup'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param Region $item
     */
    public function loadFromItem($item)
    {
        $this->title = $item->title;
        $this->sort = $item->sort;
        $this->is_default = $item->is_default;
        $this->country_id = $item->country_id;
        $this->popup = $item->popup;
    }

    /**
     * @inheritdoc
     * @var Region $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->sort = $this->sort;
        $item->is_default = $this->is_default;
        $item->country_id = $this->country_id;
        $item->popup = $this->popup;

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

        $item = new Region();

        $item->title = $this->title;
        $item->sort = $this->sort;
        $item->is_default = $this->is_default;
        $item->country_id = $this->country_id;
        $item->popup = $this->popup;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'is_default' => 'По умолчанию',
            'popup' => 'В попап'
        ];
    }
}
