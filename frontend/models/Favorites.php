<?php

namespace frontend\models;

use common\models\CatalogCategory;
use common\models\CatalogItem;
use Illuminate\Support\Arr;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;
use yii\web\Cookie;

class Favorites
{
    const COOKIE_NAME = '__favorites';

    public static function count()
    {
        $favorites = self::getFromCookies();
        return !empty($favorites) ? CatalogItem::find()->where(['id' => ArrayHelper::getColumn($favorites, 'id')])->count() : 0;
    }

    /**
     * @return mixed
     */
    public static function getFromCookies()
    {
        return Json::decode(Yii::$app->request->cookies->get(self::COOKIE_NAME));
    }

    /**
     * @param integer $id
     * @return bool
     */
    public static function isInFavorites($id)
    {
        $in = false;
        $favorites = self::getFromCookies();
        if (!empty($favorites)) {
            foreach ($favorites as $favorite) {
                if ((int) $favorite['id'] === (int) $id) {
                    $in = true;
                }
            }
        }

        return $in;
    }

    /**
     * @param integer $id
     * @return integer Number of items in favorites
     */
    public static function add($id)
    {
        if (false === self::isInFavorites($id)) {
            $favorites = self::getFromCookies();
            $favorites[] = ['id' => $id];


            Yii::$app->response->cookies->add(
                new Cookie([
                    'name' => self::COOKIE_NAME,
                    'value' => Json::encode($favorites)
                ])
            );

            return count($favorites);
        }

        return self::count();
    }

    public static function generateCSV($category_id)
    {
        $items = self::getItems();
        $data  = "\xEF\xBB\xBF"; // UTF-8 BOM

        if (!empty($items)) {
            $attributes = self::compare($category_id, $items);

            $order = ArrayHelper::getColumn($attributes, 'id');
            $header = ArrayHelper::getColumn($attributes, 'title');

            $data .= 'Название,' . implode(',', $header) . "\n";

            foreach ($items as $item) {
                $info = $item->getInfo($category_id, $order);
                $data .=  $item->title . ',' . implode(',', $info) . "\n";
            }
        }

        return $data;
    }

    /**
     * @param integer $id
     * @return integer Number of items in favorites
     */
    public static function remove($id)
    {
        $favorites = self::getFromCookies();

        if (!empty($favorites)) {
            foreach ($favorites as $k => $favorite) {
                if ((int) $favorite['id'] === (int) $id) {
                    unset($favorites[$k]);
                }
            }

            Yii::$app->response->cookies->add(
                new Cookie([
                    'name' => self::COOKIE_NAME,
                    'value' => Json::encode($favorites)
                ])
            );
        }

        return count($favorites);
    }

    public static function getItems()
    {
        if (!empty(self::getFromCookies())) {
            return CatalogItem::find()->where(['id' => ArrayHelper::getColumn(self::getFromCookies(), 'id')])->all();
        }

        return [];
    }

    /**
     * @param int $category_id
     * @param $items
     * @return array
     */
    public static function compare($category_id, $items)
    {
        return CatalogItem::compare($category_id, $items);
    }
}