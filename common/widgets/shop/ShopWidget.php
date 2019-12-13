<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 30/03/15
 * Time: 23:29
 */

namespace common\widgets\shop;

use common\models\CatalogItem;
use common\models\Department;
use common\models\PageBlock;
use common\models\Region;
use Yii;
use common\components\MyExtensions\MyWidget;

class ShopWidget extends MyWidget
{
    public static function getForm(){
        return '\common\widgets\shop\forms\ShopWidgetForm';
    }

    public static function getBlockName(){
        return 'Точки продаж';
    }

    public function init(){
        parent::init();
        if($this->page_id == null)
            return false;
    }


    /**
     * @return string
     */
    public function run()
    {
        $model = $this->getModel();
        $query = Department::find();
        $query->where(['region_id' => Region::getCurrent()->id]);

        if (!empty($model->select)) {
            $query->andWhere(['id' => $model->select]);
        }

        $items = $query->limit(3)->all();

        return $this->render('shop', [
            'model' => $model,
            'items' => $items
        ]);
    }
}