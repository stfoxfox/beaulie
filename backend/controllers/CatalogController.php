<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 00:47
 */

namespace backend\controllers;

use backend\models\forms\AddCatalogCategoryForm;
use backend\models\forms\CatalogCategoryAttributeForm;
use backend\models\forms\CatalogItemForm;
use backend\models\forms\CatalogItemImageForm;
use backend\models\forms\CatalogItemPictureForm;
use backend\models\forms\EditCatalogCategoryForm;
use backend\models\forms\PagePictureForm;
use backend\models\forms\StylingForm;
use backend\models\forms\XlsxImportForm;
use common\components\actions\Add;
use common\components\actions\Edit;
use common\components\controllers\BackendController;
use common\models\Attribute;
use common\models\AttributeValue;
use common\models\CatalogCategory;
use common\models\CatalogCategoryAttribute;
use common\models\CatalogItem;
use common\models\CatalogItemImage;
use common\models\File;
use common\models\Ingredient;
use common\models\Language;
use common\models\Styling;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class CatalogController extends BackendController
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
                '_model' => CatalogCategory::className(),
            ],
            'item-dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => CatalogItem::className(),
            ],
            'dell-category-attribute' => [
                'class' => 'common\components\actions\Dell',
                '_model' => CatalogCategoryAttribute::className(),
            ],
            'dell-category-styling' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Styling::className(),
            ],
            'gallery-add-picture' => [
                'class' => 'common\components\actions\BlockAddPicture',
                '_model' => File::className(),
                '_form' => 'backend\models\forms\CatalogItemPictureForm',
                'related_model_path'=>CatalogItem::tableName()
            ],
            'gallery-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => File::className(),
            ],
            'dell-gallery-item' => [
                'class' => 'common\components\actions\Dell',
                '_model' => File::className(),
            ],
            'save-image-data' => [
                'class' => 'common\components\actions\SaveBlockData',
                '_model' => File::className(),
            ],
            'sort-category-attributes' => [
                'class' => 'common\components\actions\Sort',
                '_model' => CatalogCategoryAttribute::className()
            ],
            'sort-category-styling' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Styling::className()
            ],
        ];
    }



    public function actionSaveOrder()
    {
        $order = \Yii::$app->request->post('sort_data');
        $orders = json_decode($order,true);

        $sort_id = 0;
        foreach ($orders as $item){
            $item_obj = CatalogCategory::findOne($item['id']);
            if ($item_obj) {
                $item_obj->parent_catalog_category_id=null;
                $item_obj->sort=$sort_id;
                $item_obj->save();
                if (ArrayHelper::getValue($item,'children')){
                    self::getTree(ArrayHelper::getValue($item,'children'),$item_obj->id);
                }
            }

            $sort_id++;
        }
    }


    public static function getTree($node,$parent_id){


        $sort_id = 0;
        foreach ($node as $item){

            /**
             * @var CatalogCategory
             */
            $item_obj = CatalogCategory::findOne($item['id']);

            if ($item_obj){

                $item_obj->parent_catalog_category_id=$parent_id;
                $item_obj->sort=$sort_id;

                $item_obj->save();
                if (ArrayHelper::getValue($item,'children')){
                    self::getTree(ArrayHelper::getValue($item,'children'),$item_obj->id);
                }
            }

            $sort_id++;

        }

    }



    public function actionView($id = null)
    {
        if (isset($id)) {
            $categoryObj = CatalogCategory::findOne($id);

            if ($categoryObj) {

                $this->setTitleAndBreadcrumbs('Управление категориями: '.$categoryObj->title_ru,[

                    ['label'=>'Управление категориями']

                ]);

                return $this->render('index', [
                    'category' => $categoryObj,
                    'roots'=>CatalogCategory::find()->where('parent_catalog_category_id is null')->orderBy('sort, created_at')->all()
                ]);

            } else {
                return $this->redirect(Url::toRoute(['catalog/view']));
            }
        } else {
            $category = CatalogCategory::find()->limit(1)->orderBy('sort')->one();
            if ($category) {
                return $this->redirect(Url::toRoute(['catalog/view', 'id' => $category->id]));
            }
        }

        $addCatalogCategoryForm = new AddCatalogCategoryForm();

        if ($addCatalogCategoryForm->load(Yii::$app->request->post())) {
            if ($newCategory = $addCatalogCategoryForm->createCategory()) {
                return $this->redirect(Url::toRoute(['catalog/view', 'id' => $newCategory->id]));
            }
        }


        return $this->render('add-category', [
            'addForm' => $addCatalogCategoryForm,

        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteAll()
    {
        CatalogItem::truncate();
        return $this->redirect(Url::toRoute(['catalog/view']));
    }

    public function actionEditItem($id,$category_id=null)
    {


        $category = CatalogCategory::findOne($category_id);

        $action = new Edit('edit-item',$this,[

            '_editForm' => 'backend\models\forms\CatalogItemForm',
            '_model' => CatalogItem::className(),
            '_redirect'=>['edit-item','id'=>$id,'category_id'=>$category_id],
            'page_header'=>"Изменение элемента ктаталога",
            'breadcrumbs'=>[
                ['label'=> "Управление категориями",'url'=>['catalog/view']],
                ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/view','id'=>$id]]

            ],
            'extra_params'=>['category_id'=>$category_id]


        ]);

        return $action->run($id);
    }

    /**
     * @param string $id Category ID.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAddItem($id)
    {
        $category = CatalogCategory::findOne($id);

        if (!$category) {
            throw  new NotFoundHttpException("Категории не существует");
        }

        $action = new Add('add-item',$this,[
            '_form' => 'backend\models\forms\CatalogItemForm',
            '_view'=>"add-item",
            '_redirect'=>'edit-item',
            'page_header'=>"Добавление элемента каталога",
            'breadcrumbs'=>[
                ['label'=> "Управление категориями",'url'=>['catalog/view']],
                ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/view','id'=>$id]]


            ]

        ]);

        return $action->run($id);
    }

    public function actionEditCategory($id)
    {
        $category = CatalogCategory::findOne($id);

        $action = new Edit("EditCategory",$this,[
            '_editForm' => 'backend\models\forms\CatalogCategoryForm',
                '_view'=>'edit-category',
                '_redirect'=>'edit-category',
                '_model' => CatalogCategory::className(),
                'page_header'=>"Изменение категории",
                'breadcrumbs'=>[
                    ['label'=> "Управление категориями",'url'=>['catalog/view']],
                    ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/view','id'=>$id]]

                ]
            ]
        );

        return $action->run($id);
    }

    public function actionItemsSort($id)
    {
        \Yii::$app->response->format = 'json';
        $sort = \Yii::$app->request->post('sort_data');

        if ($sort) {
            $i=0;
            foreach($sort as $block_id){
                if (strlen($block_id)>0) {
                    $i++;
                    Yii::$app->db->createCommand()
                        ->update('catalog_item_category', ['sort' => $i], "catalog_item_id = {$block_id} and catalog_category_id = $id ")
                        ->execute();
                    //$model::updateAll(['sort' => $i], ['id' => $block_id]);

                }
            }
            return array('error'=>false,);
        } else{
            return array('error'=>true,);
        }
    }




    /**
     * @param string $categoryId
     * @return mixed
     */
    public function actionItemDellFromCategory($categoryId)
    {
        $item_id = Yii::$app->request->post('item_id');
        $category = CatalogCategory::findOne($categoryId);
        $item = CatalogItem::findOne($item_id);

        if ($category && $item){
            $item->unlink('catalogCategories',$category,true);
            return $this->sendJSONResponse( array('error'=>false,'item_id'=>$item_id));
        }


        return $this->sendJSONResponse( array('error'=>true));

    }

    public function actionAddCategory()
    {
        $title = Yii::$app->request->post('title');
        if ($title) {
            $category = new CatalogCategory();
            $category->title_ru = $title;

            if ($category->save()) {
                return $this->sendJSONResponse([
                    'error' => false,
                    'category_title' => $category->title_ru,
                    'category_id' => $category->id,
                ]);
            }
        }

        return $this->sendJSONResponse(array('error' => true));
    }



    public function actionManageGallery($id,$category_id=null)
    {
        /**
         * @var CatalogItem $item
         */
        $item = CatalogItem::findOne($id);
        if ($item) {

            $addPictureForm = new CatalogItemPictureForm();
            $addPictureForm->catalog_item_id = $item->id;

            $category = CatalogCategory::findOne($category_id);

            $this->setTitleAndBreadcrumbs("Управление галереей блока: $item->title",[

                ['label'=> "Управление каталогом",'url'=>['catalog/view']],
                ['label'=> (($category)?$category->title:""),'url'=>['catalog/view','id'=>$id]],

                ['label'=> $item->title,'url'=>['catalog/edit-item','id'=>$item->id,'category_id'=>$category_id]]


            ]) ;

            return $this->render('manage-gallery', ['item' => $item, 'addPictureForm' => $addPictureForm]);
        }

        throw new NotFoundHttpException("Запись не найдена");
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEditAttributes($id)
    {
        $category = CatalogCategory::findOne($id);

        if (!$category) {
            throw  new NotFoundHttpException("Категории не существует");
        }

        $this->setTitleAndBreadcrumbs("Управление атрибутами категории: $category->title_ru", [
            ['label'=> "Управление категориями", 'url'=>['catalog/view']],
            ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/edit-category','id'=>$id]]
        ]) ;

        return $this->render('edit-attributes', [
            'category' => $category,
            'items' => $category->getCategoryAttributes()->all()
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddAttribute($id)
    {
        $category = CatalogCategory::findOne($id);

        if (!$category) {
            throw  new NotFoundHttpException("Категории не существует");
        }

        $this->setTitleAndBreadcrumbs("Добавление атрибута: $category->title_ru", [
            ['label'=> "Управление категориями", 'url'=>['catalog/view']],
            ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/view','id'=>$id]]
        ]);

        $model = new CatalogCategoryAttributeForm([
            'category_id' => $id
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['edit-attributes', 'id' => $id]);
        }

        return $this->render('add-attribute', [
            'category' => $category,
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEditStyling($id)
    {
        $category = CatalogCategory::findOne($id);

        if (!$category) {
            throw  new NotFoundHttpException("Категории не существует");
        }

        $this->setTitleAndBreadcrumbs("Управление укладкой и уходом категории: $category->title_ru", [
            ['label'=> "Управление категориями", 'url'=>['catalog/view']],
            ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/edit-category','id'=>$id]],
            ['label' => 'Управление укладкой и уходом']
        ]) ;

        return $this->render('edit-styling', [
            'category' => $category,
            'items' => $category->getStylings()->orderBy('sort')->all(),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddStyling($id)
    {
        $category = CatalogCategory::findOne($id);

        if (!$category) {
            throw  new NotFoundHttpException("Категории не существует");
        }

        $this->setTitleAndBreadcrumbs("Добавление элемента укладки и ухода: $category->title_ru", [
            ['label'=> "Управление категориями", 'url'=>['catalog/view']],
            ['label'=> (($category)?$category->title_ru:""),'url'=>['catalog/view','id'=>$id]],
            ['label' => 'Управление укладкой и уходом категории '.$category->title_ru, 'url' => ['catalog/edit-styling', 'id' => $category->id]],
            ['label' => "Добавление элемента укладки и ухода: $category->title_ru"]
        ]);

        $model = new StylingForm([
            'category_id' => $id
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['edit-styling', 'id' => $id]);
        }

        return $this->render('add-styling', [
            'category' => $category,
            'model' => $model,
            'languages' => Language::getActive()
        ]);
    }

    public function actionEditItemStyling($id)
    {
        $styling = Styling::findOne($id);

        if (!$styling) {
            throw  new NotFoundHttpException("Категории не существует");
        }

        $this->setTitleAndBreadcrumbs("Изменение элемента укладки и ухода: {$styling->category->title_ru}", [
            ['label'=> "Управление категориями", 'url'=>['catalog/view']],
            ['label'=> (($styling->category)?$styling->category->title_ru:""),'url'=>['catalog/view','id'=>$id]],
            ['label' => 'Управление укладкой и уходом категории '.$styling->category->title_ru, 'url' => ['catalog/edit-styling', 'id' => $styling->category->id]],
            ['label' => "Изменение элемента укладки и ухода:". $styling->category->title_ru]
        ]);

        $model = new StylingForm();
        
        $model->loadFromItem($styling);

        if ($model->load(Yii::$app->request->post()) && $model->edit($styling)) {
            return $this->redirect(['edit-styling', 'id' => $styling->category->id]);
        }

        return $this->render('edit-item-styling', [
            'category' => $styling->category,
            'model' => $model,
            'languages' => Language::getActive(),
            'item' => $styling
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionLinkAttribute($id)
    {
        $cat = CatalogItem::findOne($id);
        $attr = Attribute::findOne(Yii::$app->request->post('pk'));
        $val = Yii::$app->request->post('value');

        if (!$attr || !$cat || !$val) {
            throw new NotFoundHttpException;
        }

        if ($attr->type === Attribute::TYPE_SELECT) {
            $val = AttributeValue::findOne($val);
            if (!$val)
                throw new NotFoundHttpException;
        }

        $extra = [];
        switch ($attr->type) {
            case Attribute::TYPE_BOOL:
                $extra['bool_value'] = $val;
                break;

            case Attribute::TYPE_NUMBER:
            case Attribute::TYPE_STRING:
                $extra['string_value_ru'] = $val;
                break;

            case Attribute::TYPE_SELECT:
                $extra['attribute_value_id'] = $val->id;
                break;
        }

        if ($cat->isAttributeLinked($attr)) {
            $cat->unlink('attributeModels', $attr, true);
        }

        $cat->link('attributeModels', $attr, $extra);
        return $this->sendJSONResponse(['error' => false]);
    }

    /**
     * @param integer $id
     * @param integer $attr_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUnlinkAttribute($id, $attr_id)
    {
        $cat = CatalogItem::findOne($id);
        $attr = Attribute::findOne($attr_id);
        if (!$attr || !$cat) {
            throw new NotFoundHttpException;
        }

        if ($cat->isAttributeLinked($attr)) {
            $cat->unlink('attributeModels', $attr, true);
        }

        return $this->sendJSONResponse(['error' => false]);
    }
}