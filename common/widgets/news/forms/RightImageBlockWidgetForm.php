<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class RightImageBlockWidgetForm extends WidgetModel
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
            [['title'], 'required'],
            [['text', 'title'], 'string'],
            [['image'], 'file', 'extensions' => ['jpg','jpeg','png'], 'maxFiles' => 1]
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'image' => 'imageInput'
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image' => 'Изображение'
        ];
    }
}
?>