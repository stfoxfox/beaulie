<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\CatalogCategory;
use common\models\Page;
use common\models\Styling;
use yii\web\NotFoundHttpException;

class StylingController extends FrontendController
{
    public function actionView($id = null)
    {
        $categories = CatalogCategory::find()->where(['id' => Styling::find()->select('category_id')])->all();

        if($id == null){
            $id = $categories[0]->id;
        }
        $category = CatalogCategory::findOne($id);

        $styling = Styling::find()->where(['category_id' => $id])->orderBy('sort')->all();
        return $this->render('index', [
            'category' => $category,
            'styling' => $styling,
            'categories' => $categories,
            'id' => $id
        ]);
    }
}