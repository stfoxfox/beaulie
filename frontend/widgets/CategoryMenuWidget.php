<?php

namespace frontend\widgets;

use common\models\CatalogCategory;
use yii\base\Widget;

class CategoryMenuWidget extends Widget
{
    public $items;

    public function init()
    {
        $this->items = CatalogCategory::find()->all();
        parent::init();
    }

    public function run()
    {

        return $this->render('categoryMenu', [
            'items' => $this->items
        ]);
    }
}