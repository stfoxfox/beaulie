<?php

namespace common\widgets\news;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class NewsWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\news\forms\NewsWidgetForm';
    }

    public static function getBlockName(){
        return 'Новостной блок';
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
        
        if (!empty($model->select)) {
            $q->where(['id' => $model->select]);
        }

        $items = $q->limit(4)->all();

        return $this->render('news', [
            'model'  => $model,
            'items' => $items
        ]);
    }
}