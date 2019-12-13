<?php

namespace frontend\widgets;

use common\models\CatalogItem;
use yii\base\Widget;
use frontend\models\Favorites as FavoritesModel;

class Favorites extends Widget
{

    public $items;

    public function init()
    {
        $this->items = FavoritesModel::getItems();
        parent::init();
    }


    public function run()
    {
        return $this->render('favorites', [
            'items' => $this->items
        ]);
    }
}