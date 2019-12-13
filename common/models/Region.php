<?php

namespace common\models;

use Yii;
use common\models\gii\BaseRegion
;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

/**
* This is the model class for table "region".
*/
class Region extends BaseRegion
{
    const COOKIE_NAME = '__region';

    /**
     * @param int $limit
     * @param mixed $condition
     * @return array
     */
    public static function getList($limit = 4, $condition = [])
    {
        $q = self::find();
        if ($condition) $q->andWhere($condition);
        if ($limit) $q->limit($limit);
        return ArrayHelper::map($q->all(), 'id', 'title');
    }

    /**
     *
     */
    public function setCookie()
    {
        $cookies = Yii::$app->response->cookies;
        $cookie = new Cookie([
            'name' => self::COOKIE_NAME,
            'value' => $this->id,
            'expire' => time() + 86400 * 31,
        ]);
        $cookies->add($cookie);
    }

    /**
     * @return static
     */
    public static function getCurrent()
    {
        $cookies = Yii::$app->request->cookies;
        if (isset($cookies[self::COOKIE_NAME])) {
            $model = self::findOne($cookies[self::COOKIE_NAME]->value);
        } else {
            $model = self::findOne(['is_default' => true]);
        }

        if (!$model) {
            return self::find()->orderBy('id')->one();
        } else {
            return $model;
        }
    }
}
