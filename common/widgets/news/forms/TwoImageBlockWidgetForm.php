<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class TwoImageBlockWidgetForm extends WidgetModel
{
	public $first_image;
    public $second_image;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['first_image', 'second_image'], 'file', 'extensions' => ['jpg','jpeg','png'], 'maxFiles' => 1],
        ];
    }

    public static function types()
    {
        return [
            'first_image' => 'imageInput',
            'second_image' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_image' =>  'Первое изображние',
            'second_image' => 'Второе изображение',
        ];
    }
}
?>