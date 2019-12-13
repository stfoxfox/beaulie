<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Page;
use yii\web\NotFoundHttpException;

class CompanyController extends FrontendController
{
    public function actionIndex()
    {
        $page = Page::findOne(['slug' => 'company']);
        if (!$page)
            throw new NotFoundHttpException;

        return $this->render('index', [
            'page' => $page
        ]);
    }
}