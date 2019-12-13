<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Brand;
use common\models\Page;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;

class BrandsController extends FrontendController
{
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $page = Page::findOne(['slug' => 'brands']);
        if (!$page)
            throw new NotFoundHttpException;

        $query = Brand::find()->where(['show_on_page' => true])->orderBy('sort');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $items = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'page' => $page,
            'items' => $items,
            'pages' => $pages
        ]);
    }
}