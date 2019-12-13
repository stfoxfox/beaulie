<?php

namespace backend\controllers;

use backend\models\forms\newsPictureForm;
use common\components\controllers\BackendController;
use common\models\News;
use common\models\File;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\models\PageBlock;

class NewsController extends BackendController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
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
                '_model' => News::className(),
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\NewsForm',
                '_model' => News::className(),
                'page_header'=>"Изменение новости",
                'breadcrumbs'=>[
                    ['label'=> "Управление новостями",'url'=>['news/index']]
                ]
            ],
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\NewsForm',
                'page_header'=>"Добавление новости",
                'breadcrumbs'=>[
                    ['label'=> "Управление новостями",'url'=>['news/index']]
                ]
            ],
            'save-image-data' => [
                'class' => 'common\components\actions\SaveBlockData',
                '_model' => File::className(),
            ],

            'gallery-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => File::className(),
            ],
            'dell-gallery-item' => [
                'class' => 'common\components\actions\Dell',
                '_model' => File::className(),
            ],
            'dell-block' => [
                'class' => 'common\components\actions\Dell',
                '_model' => PageBlock::className(),
            ],
            'block-add-picture' => [
               'class' => 'common\components\actions\BlockAddPicture',
               '_model' => File::className(),
               '_form' => 'backend\models\forms\newsPictureForm',
            ],
            'block-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => PageBlock::className(),
            ],
            'block-editable' => [
                'class' => 'common\components\actions\SaveBlockData',
                '_model' => PageBlock::className() ,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs("Управление новостями") ;

        $query = News::find();
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'items' => $models,
            'pages' => $pages,
        ]);
    }
}