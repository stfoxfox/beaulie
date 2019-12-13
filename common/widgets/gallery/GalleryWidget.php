<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 30/03/15
 * Time: 23:29
 */

namespace common\widgets\gallery;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class GalleryWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\gallery\forms\GalleryWidgetForm';
    }

    public static function getBlockName(){
        return 'Блок Галереи';
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
        $images = $this->getImages();
        return $this->render('index', [
            'images' => $images
        ]);
    }
}