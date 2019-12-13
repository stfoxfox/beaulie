<?php

namespace common\widgets\shop\forms;

use common\models\Department;
use Yii;
use common\components\MyExtensions\WidgetModel;

class ShopWidgetForm extends WidgetModel
{
	public $title;
    public $select;

    public function init() {
        parent::init();
        $this->dropDownData['select'] = Department::getList();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
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
            'title' => 'Название',
            'select' => 'Магазины'
        ];
    }
}
?>