<?php

namespace backend\controllers;

use Yii;
use backend\models\forms\TagForm;
use common\components\controllers\BackendController;
use common\models\File;
use common\models\Tag;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use backend\widgets\editable\EditableAction;

class TagController extends BackendController
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
                '_model' => Tag::className(),
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\TagForm',
                '_model' => Tag::className(),
                'page_header'=>"Изменение тега",
                'breadcrumbs'=>[
                    ['label'=> "Управление тегами",'url'=>['tag/index']]
                ]
            ],
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\TagForm',
                'page_header'=>"Добавление тега",
                'breadcrumbs'=>[
                    ['label'=> "Управление тегами",'url'=>['tag/index']]
                ]
            ],
            'sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Tag::className()
            ]
            // 'editable' => [
            //     'class' => EditableAction::className(),
            //     'modelClass' => Tag::className(),
            //     'formClass' => TagForm::className(),
            // ],
            // 'add' => [
            //     'class' => 'common\components\actions\Add',
            //     '_form' => 'backend\models\forms\NewsForm',
            //     'page_header'=>"Добавление новости",
            //     'breadcrumbs'=>[
            //         ['label'=> "Управление новостями",'url'=>['page/index']]
            //     ]
            // ],
            // 'save-image-data' => [
            //     'class' => 'common\components\actions\SaveBlockData',
            //     '_model' => Tag::className(),
            // ],

            // 'gallery-sort' => [
            //     'class' => 'common\components\actions\Sort',
            //     '_model' => File::className(),
            // ],
            // 'dell-gallery-item' => [
            //     'class' => 'common\components\actions\Dell',
            //     '_model' => File::className(),
            // ],
            // 'dell-block' => [
            //     'class' => 'common\components\actions\Dell',
            //     '_model' => PageBlock::className(),
            // ],
            // 'block-add-picture' => [
            //     'class' => 'common\components\actions\BlockAddPicture',
            //     '_model' => File::className(),
            //     '_form' => 'backend\models\forms\PagePictureForm',
            // ],
        ];
    }

    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs("Управление тегами") ;

        $query = Tag::find();
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

    public function actionAddTag()
    {
        $name = Yii::$app->request->post('name');
        if ($name) {
            $tag = new Tag();
            $tag->title_ru = $name;

            if ($tag->save()) {
                return $this->sendJSONResponse([
                    'error' => false,
                    'tag_name' => $tag->title_ru,
                    'tag_id' => $tag->id,
                ]);
            }
        }

        return $this->sendJSONResponse(array('error' => true));
    }
}