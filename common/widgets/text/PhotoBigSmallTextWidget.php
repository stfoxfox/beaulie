<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 30/03/15
 * Time: 23:29
 */

namespace common\widgets\text;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class PhotoBigSmallTextWidget extends MyWidget
{
    public static function getForm()
    {
        return '\common\widgets\text\forms\PhotoBigSmallTextWidgetForm';
    }

    public static function getBlockName()
    {
        return 'Большое и маленькое фото + текст';
    }

    public function init(){
        parent::init();
        if ($this->page_id === null)
            return false;
    }

    /**
     * @return string
     */
    public function run()
    {
        $model = $this->getModel();

        return $this->render('photo_big_small_text', [
            'model' => $model
        ]);
    }
}