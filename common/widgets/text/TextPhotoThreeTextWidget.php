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

class TextPhotoThreeTextWidget extends MyWidget
{
    public static function getForm()
    {
        return '\common\widgets\text\forms\TextPhotoThreeTextWidgetForm';
    }

    public static function getBlockName()
    {
        return 'Текст, фото и 3 пункта';
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
        return $this->render('text_photo_three_text', [
            'model' => $model
        ]);
    }
}