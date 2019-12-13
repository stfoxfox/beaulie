<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class VideoBlockWidgetForm extends WidgetModel
{
	public $link;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'string'],
        ];
    }

    public static function types()
    {
        return [
            'link' => 'link',
        ];
    }

    public function attributeLabels()
    {
        return [
            'link' => 'Ссылка на видео',
        ];
    }
}
?>