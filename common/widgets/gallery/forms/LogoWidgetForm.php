<?php

namespace common\widgets\gallery\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

class LogoWidgetForm extends WidgetModel
{
	public $title;
    public $text;
    public $link;
    public $select;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title', 'text'], 'string'],
            [['link'], 'url'],
            [['select'], 'integer'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'link' => 'link',
            'select' => 'gallery',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'link' => 'Ссылка',
            'text' => 'Текст'
        ];
    }
}
?>