<?php

namespace frontend\widgets;

use common\models\CatalogCategory;
use common\models\CatalogItem;
use yii\base\Widget;

class CatalogItemSummary extends Widget
{
    public function run()
    {
        $currentCategory = CatalogCategory::getCurrent();
        $id = $currentCategory ? $currentCategory->id : false;
        $homeCount = CatalogItem::getHomeCount($id);
        $businessCount = CatalogItem::getBusinessCount($id);
        return $this->render('catalogItemSummary', [
            'currentCategory' => $currentCategory,
            'homeCount' => $homeCount,
            'businessCount' => $businessCount
        ]);
    }
}