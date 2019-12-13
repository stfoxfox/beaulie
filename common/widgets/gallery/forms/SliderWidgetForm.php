<?php

namespace common\widgets\gallery\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

class SliderWidgetForm extends WidgetModel
{
	public $title;
    public $link;
    public $select;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'string'],
            [['link'], 'url'],
            [['select'], 'integer'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'link' => 'link',
            'select' => 'gallery',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'link' => 'Ссылка'
        ];
    }
}
?>