<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class ImageBlockWidgetForm extends WidgetModel
{
	public $file_name;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'], 'maxFiles' => 1],
        ];
    }

    public static function types()
    {
        return [
            'file_name' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'file_name' => 'Изображение',
        ];
    }
}
?>