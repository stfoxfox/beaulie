<?php

namespace common\widgets\text\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

class TextPhotoThreeTextWidgetForm extends WidgetModel
{
	public $title;
    public $text;
    public $p1_text;
    public $p2_text;
    public $p3_text;
    public $image;


    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'string'],
            [['text', 'p1_text', 'p2_text', 'p3_text'], 'string'],
            [['image'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],

        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'image' => 'imageInput',
            'p1_text' => 'textArea',
            'p2_text' => 'textArea',
            'p3_text' => 'textArea',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
            'p1_text' => 'Текст №1',
            'p2_text' => 'Текст №2',
            'p3_text' => 'Текст №3',
            'image' => 'Изображение',
        ];
    }
}
?>