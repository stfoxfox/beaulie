<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\CatalogCategory;
use common\models\CatalogItem;
use common\models\Collection;
use frontend\models\CatalogItemSearch;
use frontend\models\CollectionSendForm;
use yii\web\NotFoundHttpException;

class CatalogController extends FrontendController
{
    /**
     * @param integer $id
     * @param bool $is_home
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id, $is_home = false)
    {
        $category = CatalogCategory::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException;
        }
        $is_home = boolval($is_home);
        $category->setCookie();

        $model = new CatalogItemSearch([
            'category_id' => $category->id,
            'is_home' => $is_home
        ]);

        $data = $model->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isAjax) {
            return $this->asJson([
                'count' => count($data),
                'html' => $this->renderAjax('_catalog', [
                    'category' => $category,
                    'model' => $model,
                    'data' => $data,
                    'is_home' => $is_home,
                ])
            ]);
        }

        return $this->render('index', [
            'category' => $category,
            'model' => $model,
            'data' => $data,
            'is_home' => $is_home
        ]);
    }

    public function actionView($collection_id, $item_id = false, $is_home = false)
    {
        $collection = Collection::findOne($collection_id);
        if (!$collection) {
            throw new NotFoundHttpException;
        }

        $form = new CollectionSendForm(['model' => $collection]);
        if ($form->load(\Yii::$app->request->post(), '') && $form->send()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app.flashes', 'Вам успешно отправлен файл'));
        }

        $category = CatalogCategory::getCurrent();

        $items = CatalogItem::find()
            ->where(['collection_id' => $collection->id])
            ->orderBy('title')
            ->all();

        return $this->render('view', [
            'category' => $category,
            'collection' => $collection,
            'items' => $items,
            'is_home' => $is_home
        ]);
    }
}