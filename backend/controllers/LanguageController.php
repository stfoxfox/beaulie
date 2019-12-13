<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19/07/2017
 * Time: 15:23
 */

namespace backend\controllers;


use common\components\controllers\BackendController;
use common\models\Language;

class LanguageController extends BackendController
{

    public function actionIndex(){


      $this->setTitleAndBreadcrumbs('Управление языками');
        $items = Language::find()->all();


        return $this->render('index',['items'=>$items]);
    }



    public function actionChangeStatus(){


        $item_id = \Yii::$app->request->post('item_id');

        if($item_id){

            /** @var Language $user */
            if($item = Language::findOne($item_id)){

               if ($item->is_active) {
                   $item->is_active =0;

               } else{

                   $item->is_active =1;
               };
                $item->save();



                return $this->sendJSONResponse(array('error'=>false,'language_id'=>$item->id,'status'=>$item->is_active));
            }
        }



        return $this->sendJSONResponse(array('error'=>true));


    }

}