<?php

namespace backend\models\forms;

use common\models\Region;
use Yii;
use yii\base\Model;
use common\models\Department;
/**
* This is the model class for Department form.
*/
class DepartmentForm extends Model
{
    public $title;
    public $address;
    public $parent_id;
    public $phone;
    public $phone_2;

    public $site_url;
    public $lat;
    public $lng;
    public $sort;
    public $is_active;


    public  $searchTitle;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id', 'sort'], 'integer'],

            [['lat', 'lng'], 'number'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['title', 'address', 'phone', 'phone_2', 'site_url',], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @param Department $item
     */
    public function loadFromItem($item)
    {
        $this->title = $item->title;
        $this->address = $item->address;
        $this->parent_id = $item->region_id;
        $this->phone = $item->phone;
        $this->phone_2 = $item->phone_2;

        $this->site_url = $item->site_url;
        $this->lat = $item->lat;
        $this->lng = $item->lng;
        $this->sort = $item->sort;
        $this->is_active = $item->is_active;
    }

    /**
     * @inheritdoc
     * @var Department $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->address = $this->address;
        $item->phone = $this->phone;
        $item->phone_2 = $this->phone_2;

        $item->site_url = $this->site_url;
        $item->lat = $this->lat;
        $item->lng = $this->lng;
        $item->sort = $this->sort;
        $item->is_active = $this->is_active;
    
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

        $item = new Department();

        $item->title = $this->title;
        $item->address = $this->address;
        $item->region_id = $this->parent_id;
        $item->phone = $this->phone;
        $item->phone_2 = $this->phone_2;
        $item->site_url = $this->site_url;
        $item->lat = $this->lat;
        $item->lng = $this->lng;
        $item->sort = $this->sort;
        $item->is_active = $this->is_active;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
