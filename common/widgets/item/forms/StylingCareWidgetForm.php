<?php

namespace common\widgets\item\forms;

use common\models\CatalogCategory;
use Yii;
use common\components\MyExtensions\WidgetModel;

class StylingCareWidgetForm extends WidgetModel
{
    public $title;
    public $text;
    public $file_name;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['text', 'title'], 'safe'],
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'], 'maxFiles' => 1],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'file_name' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'text' => 'Текст',
            'file_name' => 'Изображение',
        ];
    }
}
?>