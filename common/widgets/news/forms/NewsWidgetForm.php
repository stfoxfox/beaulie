<?php

namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\CatalogItem;

class NewsWidgetForm extends WidgetModel
{
	public $title;
    public $select;


    public function init() {
        $this->dropDownData['select'] = CatalogItem::getList();
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
            [['select'], 'safe'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'select' => 'select2',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'select' => 'Товары'
        ];
    }
}
?>