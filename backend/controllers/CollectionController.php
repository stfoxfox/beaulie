<?php

namespace backend\controllers;

use common\components\controllers\BackendController;
use common\models\Collection;
use yii\filters\AccessControl;

class CollectionController extends BackendController
{
    /**
     * @return array
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
            ]
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\CollectionForm',
                '_redirect' => 'index',
                'page_header' => 'Добавление коллекции',
                'breadcrumbs' => [
                    ['label' => 'Управление колекциями', 'url' => ['collection/index']]
                ]
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\CollectionForm',
                '_model' => Collection::className(),
                '_view' => 'edit',
                '_redirect' => 'edit',
                'page_header' => "Изменение коллекции",
                'breadcrumbs' => [
                    ['label' => "Управление коллекциями", 'url' => ['collection/index']],
                ],
            ],
            'dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Collection::className(),
            ],
            'sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Collection::className()
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Коллекции');
        
        $items = Collection::find()->orderBy('sort')->all();

        return $this->render('index', [
            'items' => $items
        ]);
    }
}