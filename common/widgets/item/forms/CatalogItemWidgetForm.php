<?php

namespace common\widgets\item\forms;

use common\models\CatalogItem;
use Yii;
use common\components\MyExtensions\WidgetModel;

class CatalogItemWidgetForm extends WidgetModel
{
    const SHOW_SALE = 'sale';
    const SHOW_HIT = 'hit';

    public $title;
    public $what_to_show;
    public $select;

    public function init() {
        $this->dropDownData['what_to_show'] = [
            self::SHOW_SALE => Yii::t('app', 'Sale'),
            self::SHOW_HIT => Yii::t('app', 'Хит')
        ];
        $this->dropDownData['select'] = CatalogItem::getList();
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
            [['what_to_show', 'select'], 'safe'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'what_to_show' => 'select2',
            'select' => 'select2',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'what_to_show' => 'Что показывать',
            'select' => 'Товары'
        ];
    }
}
?>