<?php

namespace common\widgets\item;

use common\components\MyExtensions\MyWidget;
use common\models\CatalogItem;
use common\widgets\item\forms\CatalogItemWidgetForm;

class CatalogItemWidget extends MyWidget
{
    public static function getForm(){
        return '\common\widgets\item\forms\CatalogItemWidgetForm';
    }

    public static function getBlockName(){
        return 'Блок товары';
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
        $q = CatalogItem::find();
        if (empty($model->select) && $model->what_to_show) {
            switch ($model->what_to_show) {
                case CatalogItemWidgetForm::SHOW_SALE:
                    $q->where(['is_sale' => true]);
                    break;
                case CatalogItemWidgetForm::SHOW_HIT:
                    $q->where(['is_hit' => true]);
            }
        } else if ($model->select) {
            $q->where(['id' => $model->select]);
        }

        $items = $q->limit(4)->all();

        return $this->render('catalog_item', [
            'model'  => $model,
            'items' => $items
        ]);
    }
}