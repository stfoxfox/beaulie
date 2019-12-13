<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\CatalogCategory;
use frontend\models\Favorites;
use frontend\models\FavoritesSendForm;
use frontend\widgets\Favorites as FavoritesWidget;
use Yii;
use common\models\CatalogItem;
use yii\web\NotFoundHttpException;

class FavoritesController extends FrontendController
{
    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        $model = CatalogItem::findOne($id);
        if (!$model)
            throw new NotFoundHttpException;

        $count = Favorites::add($id);
        if (Yii::$app->request->isAjax) {
            return $this->asJson(['result' => true, 'count' => $count]);
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionUpdateWidget()
    {
        return (new FavoritesWidget())->run();
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionRemove($id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->asJson(['result' => true, 'count' => Favorites::remove($id)]);
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionIndex()
    {
        $category = CatalogCategory::getCurrent();
        $items = Favorites::getItems();
        $attributes = Favorites::compare($category->id, $items);

        $model = new FavoritesSendForm([
            'category_id' => $category->id
        ]);

        if ($model->load(Yii::$app->request->post(), '') && $model->send()) {
            Yii::$app->session->setFlash('success', Yii::t('app.flashes', 'Вам успешно отправлен файл'));
        }

        return $this->render('index', [
            'category' => $category,
            'model' => $model,
            'items' => $items,
            'attributes' => $attributes
        ]);
    }
}