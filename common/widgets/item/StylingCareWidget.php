<?php

namespace common\widgets\item;

use common\components\MyExtensions\MyWidget;
use common\models\CatalogCategory;
use common\models\Styling;
use common\models\PageBlock;
use common\widgets\item\forms\CatalogItemWidgetForm;

class StylingCareWidget extends MyWidget
{
    public static function getForm(){
        return '\common\widgets\item\forms\StylingCareWidgetForm';
    }

    public static function getBlockName(){
        return 'Уход и укладка';
    }

    public function init()
    {
        parent::init();
        if ($this->page_id == null)
            return false;
    }

    public function run()
    {
        $model = $this->getModel();

        $items = CatalogCategory::find()->where(['id' => Styling::find()->select('category_id')])->all();
        return $this->render('styling_care', [
            'model' => $model,
            'items' => $items,
        ]);
    }
}