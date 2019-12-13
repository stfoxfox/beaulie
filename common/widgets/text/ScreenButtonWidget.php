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

class ScreenButtonWidget extends MyWidget
{
    public static function getForm()
    {
        return '\common\widgets\text\forms\ScreenButtonWidgetForm';
    }

    public static function getBlockName()
    {
        return '1 экран раздела + кнопка';
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

        return $this->render('screen_button', [
            'model' => $model
        ]);
    }
}