<?php

namespace common\widgets\item\forms;

use common\models\CatalogCategory;
use Yii;
use common\components\MyExtensions\WidgetModel;

class CatalogStylingWidgetForm extends WidgetModel
{
    public $title;
    public $text;
    public $select;

    public function init() {
        $this->dropDownData['select'] = CatalogCategory::getItemsForSelect();
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
            [['text', 'select'], 'safe'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'select' => 'select2',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'text' => 'Текст',
            'select' => 'Подключенные категории'
        ];
    }
}
?>