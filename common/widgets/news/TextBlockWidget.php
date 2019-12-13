<?php

namespace common\widgets\news;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class TextBlockWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\news\forms\TextBlockWidgetForm';
    }

    public static function getBlockName(){
        return 'Текстовый блок новости';
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

        return $this->render('text_block', [
            'model'  => $model,
        ]);
    }
}