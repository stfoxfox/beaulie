<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class NewsBlockWidgetForm extends WidgetModel
{
	public $title;
    public $text;


    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'text'], 'string'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'text' => 'Текст'
        ];
    }
}
?>