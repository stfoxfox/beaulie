<?php

namespace backend\controllers;

use backend\models\forms\CatalogCategoryFilterForm;
use backend\models\forms\CatalogCategoryFilterGroupForm;
use common\components\controllers\BackendController;

use common\models\Attribute;
use common\models\CatalogCategory;
use common\models\CatalogCategoryFilter;
use common\models\CatalogCategoryFilterGroup;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class FilterController extends BackendController
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
                '_model' => CatalogCategoryFilter::className(),
            ],
            'sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => CatalogCategoryFilter::className()
            ],
            'sort-group' => [
                'class' => 'common\components\actions\Sort',
                '_model' => CatalogCategoryFilterGroup::className()
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Управление группами фильтров');
        $items = CatalogCategory::find()->where([
            'id' => CatalogCategoryFilterGroup::find()
                ->select('catalog_category_id')
                ->where('catalog_category_id IS NOT NULL')
                ->column()
        ])->all();

        return $this->render('index', [
            'items' => $items
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewCategory($id)
    {
        $model = CatalogCategory::findOne($id);
        if (!$model)
            throw new NotFoundHttpException;

        $this->setTitleAndBreadcrumbs('Управление группами фильтров категории: ' . $model->title, [
            ['label' => 'Список', 'url' => ['index']]
        ]);

        return $this->render('view-category', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionViewGroup($id)
    {
        $model = CatalogCategoryFilterGroup::findOne($id);
        if (!$model)
            throw new NotFoundHttpException;

        $this->setTitleAndBreadcrumbs('Управление фильтрами группы: ' . $model->title_ru, [
            ['label' => 'Управление группами фильтров', 'url' => ['view-category', 'id' => $model->catalog_category_id]]
        ]);

        return $this->render('view-group', [
            'model' => $model
        ]);
    }

    /**
     * @param null|integer $category_id
     * @return string|\yii\web\Response
     */
    public function actionAddGroup($category_id = null)
    {
        $params = [];
        if ($category_id) {
            $category = CatalogCategory::findOne($category_id);
            if ($category)
                $params['catalog_category_id'] = $category->id;
        }

        $this->setTitleAndBreadcrumbs('Добавление группы фильтров', [
            !empty($category) ? ['label' => 'Управление группами фильтров', 'url' => ['view-category', 'id' => $category->id]] : ['label' => 'Список', 'url' => ['index']]
        ]);

        $model = new CatalogCategoryFilterGroupForm($params);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['view-category', 'id' => $model->catalog_category_id]);
        }

        return $this->render('add-group', [
            'formItem' => $model
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditGroup($id)
    {
        $model = CatalogCategoryFilterGroup::findOne($id);
        if (!$model)
            throw new NotFoundHttpException;

        $this->setTitleAndBreadcrumbs('Добавление группы фильтров', [
            ['label' => 'Управление группами фильтров', 'url' => ['view-category', 'id' => $model->catalog_category_id]]
        ]);

        $formItem = new CatalogCategoryFilterGroupForm();
        $formItem->loadFromItem($model);

        if ($formItem->load(\Yii::$app->request->post()) && $formItem->edit($model)) {
            return $this->redirect(['view-category', 'id' => $model->catalog_category_id]);
        }

        return $this->render('edit-group', [
            'formItem' => $formItem
        ]);
    }

    /**
     * @param $id
     * @param $group_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAdd($id, $group_id)
    {
        $category = CatalogCategory::findOne($id);
        $group    = CatalogCategoryFilterGroup::findOne($group_id);
        if (!$category || !$group) {
            throw new NotFoundHttpException;
        }

        $this->setTitleAndBreadcrumbs('Добавление фильтра', [
            ['label' => 'Управление группами фильтров', 'url' => ['filter/index']],
            ['label' => 'Управление фильтрами группы: ' . $group->title_ru, 'url' => ['filter/edit', 'id' => $group->id]]
        ]);

        $model = new CatalogCategoryFilterForm([
            'catalog_category_id' => $category->id,
            'catalog_category_filter_group_id' => $group->id
        ]);

        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['view-group', 'id' => $group->id]);
        }

        return $this->render('add', [
            'formItem' => $model
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEdit($id)
    {
        $filter = CatalogCategoryFilter::findOne($id);
        if (!$filter)
            throw new NotFoundHttpException;

        $this->setTitleAndBreadcrumbs('Редактирование фильтра', [
            ['label' => 'Управление группами фильтров', 'url' => ['filter/index']],
            ['label' => 'Управление фильтрами группы: ' . $filter->catalogCategoryFilterGroup->title_ru, 'url' => ['filter/view-group', 'id' => $filter->catalog_category_filter_group_id]]
        ]);

        $model = new CatalogCategoryFilterForm();
        $model->loadFromItem($filter);

        if ($model->load(\Yii::$app->request->post()) && $model->edit($filter)) {
            return $this->redirect(['view-group', 'id' => $filter->catalog_category_filter_group_id]);
        }

        return $this->render('edit', [
            'item' => $filter,
            'formItem' => $model
        ]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDellGroup()
    {
        $model = CatalogCategoryFilterGroup::findOne(\Yii::$app->request->post('item_id'));
        if (!$model)
            throw new NotFoundHttpException;

        foreach  ($model->catalogCategoryFilters as $filter) {
            $filter->delete();
        }

        $model->delete();

        return $this->sendJSONResponse(['error' => false]);
    }

    /**
     *
     */
    public function actionGetViewType()
    {
        if ($type = \Yii::$app->request->post('type')) {
            return $this->sendJSONResponse([
                'error' => false,
                'data' => CatalogCategoryFilter::getViewType($type)
            ]);
        }

        if ($attr = \Yii::$app->request->post('attribute_id')) {
            $attribute = Attribute::findOne($attr);
            return $this->sendJSONResponse([
                'error' => false,
                'data' => $attribute->getViewType()
            ]);
        }
    }
}