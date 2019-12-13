<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class TextBlockWidgetForm extends WidgetModel
{
	public $text;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }

    public static function types()
    {
        return [
            'text' => 'textArea',
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Текст',
        ];
    }
}
?>