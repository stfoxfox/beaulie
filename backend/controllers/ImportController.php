<?php

namespace backend\controllers;

use backend\models\forms\DepartmentImportForm;
use backend\models\forms\DropboxImportForm;
use backend\models\forms\XlsxImportForm;
use common\components\controllers\BackendController;
use common\models\CatalogCategory;
use yii\web\NotFoundHttpException;

class ImportController extends BackendController
{
    /**
     * @param $category_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionXlsx($category_id)
    {
        $this->loadCategory($category_id);

        $this->setTitleAndBreadcrumbs('Импорт');

        $model = new XlsxImportForm([
            'category_id' => $category_id
        ]);

        if ($model->load(\Yii::$app->request->post())) {
            $model->import();
        }

        return $this->render('xlsx', [
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionDropbox()
    {
        $this->setTitleAndBreadcrumbs('Импорт изображений');

        $model = new DropboxImportForm();
        if ($model->load(\Yii::$app->request->post())) {
            $model->import();
        }

        return $this->render('dropbox', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return CatalogCategory
     * @throws NotFoundHttpException
     */
    protected function loadCategory($id)
    {
        $category = CatalogCategory::findOne($id);
        if (!$category)
            throw new NotFoundHttpException;

        return $category;
    }

    /**
     * @param int $country_id
     * @return string
     */
    public function actionDepartment($country_id)
    {
        $this->setTitleAndBreadcrumbs('Импорт магазинов');

        $model = new DepartmentImportForm([
            'country_id' => $country_id
        ]);
        if ($model->load(\Yii::$app->request->post())) {
            $model->import();
        }

        return $this->render('department', [
            'model' => $model
        ]);
    }
}