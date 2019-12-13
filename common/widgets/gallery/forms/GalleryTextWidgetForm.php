<?php

namespace common\widgets\gallery\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

class GalleryTextWidgetForm extends WidgetModel
{
	public $title;
    public $subtitle;
    public $text;
    public $select;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title', 'text', 'subtitle'], 'string'],
            [['select'], 'integer'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'subtitle' => 'textInput',
            'text' => 'textArea',
            'select' => 'gallery',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'subtitle' => 'Подзаголовок блока',
            'description' => 'Описание блока'
        ];
    }
}
?>