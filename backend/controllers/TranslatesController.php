<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/07/2017
 * Time: 15:12
 */

namespace backend\controllers;


use common\components\controllers\BackendController;
use common\components\MyExtensions\MyFileSystem;
use common\models\Language;
use common\models\Message;
use common\models\SiteSettings;
use common\models\SourceMessage;
use yii\data\Pagination;
use linslin\yii2\curl;
use yii\web\BadRequestHttpException;
use ZipArchive;

class TranslatesController extends BackendController
{


    public $apiToken;
    public $projectID;





    public function actionIndex($lang="ru",$search_key=null){


        $this->pageHeader="Управление переводами";


        $query = SourceMessage::find();

        if ($search_key){

            $query->where(['like','message',$search_key]);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('category')
            ->all();

        return $this->render('index', [
            'messages' => $models,
            'pages' => $pages,
            'lang'=>$lang
        ]);



    }

    public function actionItemSave(){

        $pk = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');
        $name = \Yii::$app->request->post('name');





        if ($item = Message::findOne(['id'=>$pk,'language'=>$name])){

            $item->translation = $value;


            $item->save();

        }
    }

}