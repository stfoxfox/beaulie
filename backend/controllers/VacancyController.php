<?php

namespace backend\controllers;

use common\components\controllers\BackendController;
use yii\filters\AccessControl;
use common\models\Vacancy;

class VacancyController extends BackendController
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

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Vacancy::className(),
            ],
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\VacancyForm',
                'page_header' => 'Добавление вакансии',
                'breadcrumbs' => [
                    ['label' => 'Управление вакансиями', 'url' => ['vacancy/index']]
                ]
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\VacancyForm',
                '_model' => Vacancy::className(),
                'page_header' => 'Изменение вакансии',
                'breadcrumbs' => [
                    ['label' => 'Управление вакансиями', 'url' => ['vacancy/index']]
                ]
            ],
            'sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Vacancy::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Вакансии');

        $items = Vacancy::find()->orderBy('sort')->all();
        return $this->render('index', [
            'items' => $items
        ]);
    }
}