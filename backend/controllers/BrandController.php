<?php

namespace backend\controllers;

use common\components\controllers\BackendController;
use common\models\Brand;
use yii\filters\AccessControl;

class BrandController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Brand::className(),
            ],
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\BrandForm',
                'page_header' => 'Добавление бренда',
                'breadcrumbs' => [
                    ['label' => 'Управление брендами', 'url' => ['brand/index']]
                ]
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\BrandForm',
                '_model' => Brand::className(),
                'page_header' => 'Изменение бренда',
                'breadcrumbs' => [
                    ['label' => 'Управление брендами', 'url' => ['brand/index']]
                ]
            ],
            'sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Brand::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Управление брендами');

        $items = Brand::find()->orderBy('sort')->all();
        return $this->render('index', [
            'items' => $items
        ]);
    }
}