<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\CatalogCategory;
use common\models\Department;
use common\models\Region;

class ShopsController extends FrontendController
{
    public function actionIndex()
    {
        $region = Region::getCurrent();
        $items = Department::find()
            ->where(['is_active' => true])
            ->andWhere(['region_id' => $region->id])
            ->all();

        $categories = CatalogCategory::find()->joinWith([
            'departments' => function($query) use ($region){
                $query->andWhere(['is_active' => true, 'region_id' => $region->id]);
            }
        ])->all();
        
        return $this->render('index', [
            'region' => $region,
            'items' => $items,
            'categories' => $categories
        ]);
    }
}