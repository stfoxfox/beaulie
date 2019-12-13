<?php

namespace backend\controllers;

use common\components\controllers\BackendController;
use common\models\Country;
use yii\filters\AccessControl;

class CountryController extends BackendController
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
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\CountryForm',
                '_view'=>'add',
                '_redirect'=>'edit',
                'page_header'=>"Добавление страны",
                'breadcrumbs'=>[
                    ['label'=> "Управление странами",'url'=>['country/index']],

                ],
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\CountryForm',
                '_model' => Country::className(),
                '_view'=>'edit',
                '_redirect'=>'edit',
                'page_header'=>"Изменение страны",
                'title_column' => 'name',
                'breadcrumbs'=>[
                    ['label'=> "Управление странами",'url'=>['country/index']],
                ],
            ],
            'dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Country::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        $items = Country::find()->all();

        $this->setTitleAndBreadcrumbs('Управление странами');

        return $this->render('index', [
            'items' => $items
        ]);
    }
}