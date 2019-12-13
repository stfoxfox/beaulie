<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 01:08
 */

namespace backend\models\forms;

use common\models\CatalogCategory;
use yii\base\Model;

class AddCatalogCategoryForm extends Model
{


    public $title;


    public function rules()
    {
        return [

            ['title', 'required'],
            ['title', 'filter', 'filter' => 'trim'],

        ];
    }



    public function createCategory(){

        if ($this->validate()){

            $newCategory = new CatalogCategory();

            $newCategory->title_ru = $this->title;

            if ($newCategory->save()){

                return $newCategory;
            }


        }


        return false;
    }

}