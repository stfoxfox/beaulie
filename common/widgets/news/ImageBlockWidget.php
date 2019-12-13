<?php

namespace common\widgets\news;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class ImageBlockWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\news\forms\ImageBlockWidgetForm';
    }

    public static function getBlockName(){
        return 'Блок с изображением для новости';
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

        return $this->render('image_block', [
            'model'  => $model,
        ]);
    }
}