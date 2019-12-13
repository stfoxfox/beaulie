<?php

namespace common\widgets\gallery;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class LogoWidget extends MyWidget
{
    public static function getForm(){
        return '\common\widgets\gallery\forms\LogoWidgetForm';
    }

    public static function getBlockName(){
        return 'Текст + логотипы';
    }

    public function init(){
        parent::init();
        if($this->page_id == null)
            return false;
    }

    /**
     * @return \common\models\File[]
     */
    public function getImages()
    {
        return PageBlock::findOne(['id' => $this->block_id])->getFiles()->orderBy('sort')->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        $model  = $this->getModel();
        $images = $this->getImages();

        return $this->render('logo', [
            'model'  => $model,
            'images' => $images
        ]);
    }
}