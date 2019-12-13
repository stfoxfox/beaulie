<?php

namespace common\widgets\brand\forms;
use common\components\MyExtensions\WidgetModel;
use common\models\Brand;


class BrandsWidgetForm extends WidgetModel
{
    public $title;
    public $brands;


    public function init() {
        parent::init();
        $this->dropDownData['brands'] = Brand::getList();
    }

    public function rules()
    {
        return [
            [['title'], 'string'],
            [['brands'], 'safe'],

        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'brands' => 'select2',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'brands' => 'Бренды',
        ];
    }
}