<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/06/2017
 * Time: 15:50
 */

namespace backend\controllers;


use backend\models\forms\SiteSettingsPictureForm;
use common\components\controllers\BackendController;
use common\models\SiteSettings;
use common\models\File;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class SiteSettingsController extends BackendController
{


//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//
//                    [
//
////                        'allow' => true,
////                        'roles' => ['admin'],
//                    ],
//                ],
//            ],
//        ];
//    }



    public function actions()
    {
        return [
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\SiteSettingsForm',
                '_model' => SiteSettings::className() ,
            ],
            'add-picture' => [
                'class' => 'common\components\actions\SiteSettingsAddPicture',
                '_model' => File::className(),
                '_form' => 'backend\models\forms\SiteSettingsPictureForm',
            ],
            'dell-picture' => [
                'class' => 'common\components\actions\Dell',
                '_model' => File::className(),
            ],
        ];
    }

    public function actionIndex($id = null)
    {
        $this->setTitleAndBreadcrumbs("Настройки сайта");

        $settingsQ = SiteSettings::find();
        if (isset($id)) {
            $settingsQ->where(['parent_id'=>$id]);
        } else {
            $settingsQ->where('parent_id is null');
        }

        $settings= $settingsQ->orderBy('id') ->all();


        return $this->render('index',['settings'=>$settings]);
    }


    public function actionItemEdit()
    {
        $pk = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');

        if ($item = SiteSettings::findOne($pk)){

                switch ($item->type){
                    case SiteSettings::SiteSettings_TypeString:{
                        $item->string_value= $value;
                    }
                    break;
                    case SiteSettings::SiteSettings_TypeText:{
                        $item->text_value=$value;
                    }
                    break;
                    case SiteSettings::SiteSettings_TypeNumber:{

                        $item->number_value=$value;
                    }
                    break;
                    case SiteSettings::SiteSettings_TypeBool:
                    {

                    }
                    break;
                }
                $item->save();
                return $this->sendJSONResponse(['success'=>true]);

        }

        throw  new NotFoundHttpException('Элемент не найден');

    }

    public function actionManageGallery($id)
    {
        $item = SiteSettings::findOne($id);
        if (!$item)
            throw new NotFoundHttpException;

        $addPictureForm = new SiteSettingsPictureForm();
        $addPictureForm->site_settings_id = $item->id;

        $this->setTitleAndBreadcrumbs("Управление галереей: $item->title",[

            ['label'=> "Управление настройками",'url'=>['index']],


        ]) ;

        return $this->render('manage-gallery', ['item' => $item, 'addPictureForm' => $addPictureForm]);
    }
}