<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 17.08.15
 * Time: 17:43
 */

namespace common\components\controllers;

use yii\web\Controller;
use Yii;

class BackendController extends Controller {

    public $pageHeader;
    public $show_header=true;
    public $forceActive=false;
    /** @var  ImagePublisher $image_publisher */
    public $image_publisher;



    public  function  sendJSONResponse($data,$httpStatus=200,$isError=null){
        \Yii::$app->response->format = 'json';
        return $data;

    }

    public  function serializeData($data)
    {
        return Yii::createObject($this->serializer)->serialize($data);
    }



    public function setTitleAndBreadcrumbs($title,$breadcrumbs=null,$header=null){



        $this->view->title=$title;
        if (isset($header)){

            $this->view->params['pageHeader'] = $header;

        }else{

            $this->view->params['pageHeader'] = $title;
        }


        if (isset($breadcrumbs)){
            foreach ($breadcrumbs as $breadcrumb){

                $this->view->params['breadcrumbs'][] = $breadcrumb;
            }

        }



    }



}