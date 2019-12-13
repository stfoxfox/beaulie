<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/07/2017
 * Time: 22:14
 */

namespace backend\controllers;

use backend\models\forms\PagePictureForm;
use common\components\controllers\BackendController;
use common\models\File;
use common\models\Page;
use common\models\PageBlock;
use common\models\PageBlockImage;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class PageController extends BackendController
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
                '_model' => Page::className(),
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\PageForm',
                '_model' => Page::className(),
                'page_header'=>"Изменение страницы",
                'breadcrumbs'=>[
                    ['label'=> "Управление страницами",'url'=>['page/index']]
                ]
            ],
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\PageForm',
                'page_header'=>"Добавление страницы",
                'breadcrumbs'=>[
                    ['label'=> "Управление страницами",'url'=>['page/index']]
                ]
            ],
            'block-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => PageBlock::className(),
            ],
            'block-editable' => [
                'class' => 'common\components\actions\SaveBlockData',
                '_model' => PageBlock::className() ,
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
                '_form' => 'backend\models\forms\PagePictureForm',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs("Управление страницами") ;

        $query = Page::find()->where(['is_internal' => false]);
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

    public function actionBlocks($id)
    {
        if ($item = Page::findOne($id)) {


            $this->setTitleAndBreadcrumbs("Управление блоками страницы: $item->title",[

                ['label'=> "Управление страницами",'url'=>['page/index']],
                ['label'=> $item->title,'url'=>['page/edit','id'=>$item->id]]


            ]) ;


            return $this->render('blocks', ['item' => $item]);
        }

        throw new NotFoundHttpException("Страница не найдена");
    }

    public function actionManageGallery($id)
    {
        /**
         * @var PageBlock $item
         */
        $item = PageBlock::findOne($id);
        if ($item) {

            $addPictureForm = new PagePictureForm();
            $addPictureForm->block_id = $item->id;

            $this->setTitleAndBreadcrumbs("Управление галереей блока: $item->block_name",[

                ['label'=> "Управление страницами",'url'=>['page/index']],
                ['label'=> $item->page->title,'url'=>['page/edit','id'=>$item->page_id]],
                ['label'=> "Управление блоками",'url'=>['page/blocks','id'=>$item->page_id]]


            ]) ;

            return $this->render('manage-gallery', ['item' => $item, 'addPictureForm' => $addPictureForm]);
        }

        throw new NotFoundHttpException("Запись не найдена");
    }

    public function actionSaveWidget(){
        $formClass = \Yii::$app->request->post('model_class_name');
        $widgetClass = \Yii::$app->request->post('widget_class_name');
        $page_id = \Yii::$app->request->post('page_id');
        $page_block_id = \Yii::$app->request->post('page_block_id');
        $lang = \Yii::$app->request->post('lang', 'ru');
        $itemForm = new $formClass();

        if ($itemForm->load(\Yii::$app->request->post())){
            if ($itemForm->validate()){
                if($page_block = $itemForm->saveJson($widgetClass,$page_id,$page_block_id, $lang, 'page'))
                    return $this->renderAjax('view_widget',['model'=>$itemForm, 'class_name' => $widgetClass, 'page_block' => $page_block]);
                else
                    return $this->sendJSONResponse($itemForm->getErrors());
            }else
            {
                return $this->sendJSONResponse($itemForm->getErrors());
            }
        }
        throw  new BadRequestHttpException();
    }

    public function actionEditWidget(){
        $item_id = \Yii::$app->request->post('item_id');
        $added_id = \Yii::$app->request->post('added_id');
        $lang = \Yii::$app->request->post('lang', 'ru');

        $page_block = PageBlock::findOne($item_id);
        $widgetClass = $page_block->widgetClassName;
        $formClass = $page_block->modelClassName;
        $itemForm = new $formClass();
        $itemForm->attributes = get_object_vars($page_block->getDataParams($lang));
        if($itemForm->validate()){
            \Yii::$app->assetManager->bundles = false;
            return $this->renderAjax('add_widget',[
                'model'=>$itemForm,
                'class_name' => $widgetClass,
                'page_id' => $page_block->page_id,
                'added_id' => $added_id,
                'page_block' => $page_block,
                'lang' => $lang
            ]);
        }

        throw  new BadRequestHttpException();
    }

    public function actionGetWidget()
    {
        $page_id = \Yii::$app->request->post('parent_id');
        $type_id = \Yii::$app->request->post('type_id');
        $added_id = \Yii::$app->request->post('added_block_idx');
        $lang = \Yii::$app->request->post('lang', 'ru');
        $widget = PageBlock::BLOCKS[$type_id]['widgetClass'];
        $house = new $widget([
            'added_id'=> $added_id,
            'page_id' => $page_id,
            'params' => ['title' => 'hello'],
            'lang' => $lang
        ]);
        if($house){
            return $house->backendCreate();
        }
        throw  new BadRequestHttpException();
    }

    public function actionDeleteImageField()
    {
        $imageField = \Yii::$app->request->post('imageField');
        $block_id = \Yii::$app->request->post('block_id');
        $block = PageBlock::findOne($block_id);

        if($block->deleteBlockImageField($imageField)){
            $widgetClass = $block->widgetClassName;
            $params = $block->dataParams;
            $house = new $widgetClass(['page_id' => $block->page_id, 'params' => $params]);
            if($house){
                return $house->backendView($block);
            }
        }
        throw  new BadRequestHttpException();
    }

    public function actionDeletePageBlockGalleryImage()
    {
        $gallry_image_id = \Yii::$app->request->post('gallry_image_id');
        $block_id = \Yii::$app->request->post('block_id');
        $block = PageBlock::findOne($block_id);

        $model = \common\models\PageBlockImage::findOne($gallry_image_id);
        if($model->delete()){
            $widgetClass = $block->widgetClassName;
            $params = $block->dataParams;
            $house = new $widgetClass(['page_id' => $block->page_id, 'params' => $params]);
            if($house){
                return $house->backendView($block);
            }
        }
        throw  new BadRequestHttpException();
    }

}