<?php

namespace common\widgets\item;

use common\components\MyExtensions\MyWidget;
use common\models\CatalogItem;
use common\models\CatalogCategory;
use common\widgets\item\forms\CatalogItemWidgetForm;

class CatalogStylingWidget extends MyWidget
{
    public static function getForm(){
        return '\common\widgets\item\forms\CatalogStylingWidgetForm';
    }

    public static function getBlockName(){
        return 'Блок уход и укладка';
    }

    public function init()
    {
        parent::init();
        if ($this->page_id == null)
            return false;
    }

    public function run()
    {
        $model  = $this->getModel();
        $q = CatalogCategory::find();
        if ($model->select) {
            $q->where(['id' => $model->select]);
        }

        $items = $q->limit(4)->all();

        return $this->render('catalog_styling', [
            'model'  => $model,
            'items' => $items
        ]);
    }
}