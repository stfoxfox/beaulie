<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 30/03/15
 * Time: 23:29
 */

namespace common\widgets\brand;

use common\models\Brand;
use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class BrandsWidget extends MyWidget
{
    public static function getForm()
    {
        return '\common\widgets\brand\forms\BrandsWidgetForm';
    }

    public static function getBlockName()
    {
        return 'Блок наши бренды';
    }

    public function init(){
        parent::init();
        if ($this->page_id === null)
            return false;
    }


    /**
     * @return string
     */
    public function run()
    {
        $model = $this->getModel();
        $query = Brand::find();
        if ($model->brands) {
            $query->where(['id' => $model->brands]);
        }
        $items = $query->all();

        return $this->render('brands', [
            'model' => $model,
            'items' => $items
        ]);
    }
}