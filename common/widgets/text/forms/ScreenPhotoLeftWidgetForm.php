<?php

namespace common\widgets\text\forms;
use common\components\MyExtensions\WidgetModel;


class ScreenPhotoLeftWidgetForm extends WidgetModel
{
    public $title;
    public $text;
    public $image;


    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title', 'text'], 'string'],
            [['image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1],

        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'image' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image' => 'Изображение',
        ];
    }
}