<?php

namespace common\widgets\text\forms;
use common\components\MyExtensions\WidgetModel;


class PhotoBigSmallTextWidgetForm extends WidgetModel
{
    public $title;
    public $text;
    public $image_big;
    public $image_small;


    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title', 'text'], 'string'],
            [['image_big', 'image_small'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1],

        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'image_big' => 'imageInput',
            'image_small' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image_big' => 'Большое фото',
            'image_small' => 'Маленькое фото',
        ];
    }
}