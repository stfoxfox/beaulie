<?php

namespace common\widgets\news;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class VideoBlockWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\news\forms\VideoBlockWidgetForm';
    }

    public static function getBlockName(){
        return 'Видео блок новости';
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

        return $this->render('video_block', [
            'model'  => $model,
        ]);
    }
}