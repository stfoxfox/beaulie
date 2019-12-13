<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Brand;
use common\models\CatalogItem;
use common\models\Collection;
use common\models\Language;
use common\models\Region;
use yii\helpers\Json;
use yii\web\MethodNotAllowedHttpException;

class SearchController extends FrontendController
{
    /**
     * @return string
     * @throws MethodNotAllowedHttpException
     */
    public function actionIndex()
    {
        if (!\Yii::$app->request->isPost)
            throw new MethodNotAllowedHttpException;

        $q = \Yii::$app->request->post('q');
        if (strlen($q) > 2) {
            $brands = Brand::find()->where(['ilike', 'title_' . Language::current(), $q])->all();
            $collections = Collection::find()->where(['ilike', 'title_' . Language::current(), $q])->all();
            $items = CatalogItem::find()->where(['ilike', 'title', $q])->all();


            return $this->renderAjax('_result', [
                'brands' => $brands,
                'collections' => $collections,
                'items' => $items
            ]);
        }
    }

    /**
     * @return string
     * @throws MethodNotAllowedHttpException
     */
    public function actionRegion()
    {
        if (!\Yii::$app->request->isPost)
            throw new MethodNotAllowedHttpException;

        $q = \Yii::$app->request->post('q');
        $cb = \Yii::$app->request->get('callback');
        if ($cb && strlen($q) > 2) {
            $regions = Region::find()->where(['ilike', 'title', $q])->all();
            //$$cb['items'] = $regions;
            $json = $cb . '(' . Json::encode(['items' => $regions]) . ')';
            if (\Yii::$app->request->isAjax) {
                return $json;
            }
        }
    }
}