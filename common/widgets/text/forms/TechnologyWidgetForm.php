<?php

namespace common\widgets\text\forms;
use common\components\MyExtensions\WidgetModel;


class TechnologyWidgetForm extends WidgetModel
{
    public $title;
    public $p1_text;
    public $p1_image;
    public $p2_text;
    public $p2_image;
    public $p3_text;
    public $p3_image;
    public $p4_text;
    public $p4_image;


    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title', 'p1_text', 'p2_text', 'p3_text', 'p4_text'], 'string'],
            [['p1_image', 'p2_image', 'p3_image', 'p4_image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1],

        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'p1_text' => 'textArea',
            'p2_text' => 'textArea',
            'p3_text' => 'textArea',
            'p4_text' => 'textArea',
            'p1_image' => 'imageInput',
            'p2_image' => 'imageInput',
            'p3_image' => 'imageInput',
            'p4_image' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'p1_text' => 'Текст п.1',
            'p2_text' => 'Текст п.2',
            'p3_text' => 'Текст п.3',
            'p4_text' => 'Текст п.4',
            'p1_image' => 'Изображение п.1',
            'p2_image' => 'Изображение п.2',
            'p3_image' => 'Изображение п.3',
            'p4_image' => 'Изображение п.4',
        ];
    }
}