<?php

namespace common\widgets\news;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class RightImageBlockWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\news\forms\RightImageBlockWidgetForm';
    }

    public static function getBlockName(){
        return 'Блок с картинкой справа4 (новый)';
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

        return $this->render('right_image_block', [
            'model'  => $model,
        ]);
    }
}