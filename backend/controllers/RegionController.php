<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 23:57
 */

namespace backend\controllers;


use backend\models\forms\AddRegionForm;
use backend\models\forms\RegionForm;
use backend\models\forms\RestaurantForm;
use common\components\actions\Add;
use common\components\actions\Edit;
use common\components\controllers\BackendController;
use common\components\MyExtensions\MyHelper;
use common\models\Department;
use common\models\Region;
use common\models\Restaurant;
use common\models\WorkingDays;
use common\models\WorkingHours;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class RegionController extends BackendController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [

                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [

            'region-dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Region::className(),
            ],


            'edit-region' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\RegionForm',
                '_model' => Region::className(),
                '_view'=>'add-region',
                '_redirect'=>'edit-region',
                'page_header'=>"Изменение региона",
                'breadcrumbs'=>[
                    ['label'=> "Управление регионами",'url'=>['region/view']],
                ],
            ],

            'region-add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\RegionForm',
                '_view'=>'add-region',
                '_redirect'=>'edit-region',
                'page_header'=>"Добавление региона",
                'breadcrumbs'=>[
                    ['label'=> "Управление регионами",'url'=>['region/view']],

                ],

            ],
            'department-dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Department::className(),
            ],
            'region-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Region::className(),
            ],

            'department-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Department::className(),
            ],


        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteAllShops()
    {
        Department::truncate();
        return $this->redirect(['region-add']);
    }

    public function actionSetHours(){


        $weekday = \Yii::$app->request->post('weekday');
        $startTimeFull = \Yii::$app->request->post('start_time');
        $stopTimeFull = \Yii::$app->request->post('stop_time');

        $startTime = date("H:i",strtotime($startTimeFull));
        $stopTime = date("H:i",strtotime($stopTimeFull));

        $department_id=\Yii::$app->request->post('department_id');

        if ($department = Department::findOne($department_id)){


            $workingDay = WorkingDays::findOne(['department_id' => $department->id, 'weekday' => $weekday]);

            if (!$workingDay){

                $workingDay= new WorkingDays();
                $workingDay->department_id=$department->id;
                $workingDay->weekday=$weekday;
                $workingDay->status=WorkingDays::STATUS_HAS_HOURS;
                $workingDay->save();
            }

            if ( $workingDay = WorkingDays::findOne(['department_id' => $department->id, 'weekday' => $weekday])){


                if ($workingHours = $workingDay->getWorkingHours()->one()){

                    $workingHours->open_time=$startTime;
                    $workingHours->close_time=$stopTime;
                    $workingHours->save();
                }
                else{

                    $workingHours= new WorkingHours();
                    $workingHours->working_day_id= $workingDay->id;
                    $workingHours->open_time=$startTime;
                    $workingHours->close_time=$stopTime;
                    $workingHours->save();
                }
            }

        }

    }

    public function actionAddDepartment($id){



        $action = new Add('add-department',$this,[

            '_form' => 'backend\models\forms\DepartmentForm',
            '_view'=>'add-department',
            '_redirect'=>'edit-department',
            'page_header'=>"Добавление Магазина",
            'breadcrumbs'=>[
                ['label'=> "Управление магазинами",'url'=>['region/view','id'=>$id]],

            ],

        ]);


        return $action->run($id);

    }

    public function actionEditDepartment($id){



        $item = Department::findOne($id);

        $workingDays=[];
        $weekDaysArray=ArrayHelper::map($item->workingDays,'weekday','id');

        for ($weekDayNumber=1;$weekDayNumber<=7;$weekDayNumber++) {

            if (
                !empty($weekDaysArray[$weekDayNumber]) &&
                $day = WorkingDays::findOne($weekDaysArray[$weekDayNumber])
            ){
                $wD = $day;
            } else {
                $wD= new WorkingDays();
                $wD->department_id=$item->id;
                $wD->weekday=$weekDayNumber;
            }

            $workingDays[]=$wD;
        }

        $action = new Edit('add-department',$this,[

            '_view'=>'edit',
            '_editForm' => 'backend\models\forms\DepartmentForm',
            '_model' => Department::className(),
            '_redirect'=>'edit-department',
            'page_header'=>"Изменение магазина",
            'extra_params'=>array('workingDays'=>$workingDays),
            'breadcrumbs'=>[
                ['label'=> "Управление регионами",'url'=>['region/view']],

            ],


        ]);


        return $action->run($id);

    }
    public function actionView($id=null){



        $regions = Region::find()->orderBy('sort')->all();

        if(isset($id) && $region = Region::findOne($id) ){


            $this->setTitleAndBreadcrumbs("Управление магазинами: {$region->title}");
            return $this->render('index',['regions'=>$regions,'selectedRegion'=>$region]);

        }elseif ($region = Region::find()->limit(1)->orderBy('sort')->one()) {

            return $this->redirect(Url::toRoute(['view','id'=>$region->id]));
        }




        $addForm = new RegionForm();


        if ($addForm->load(\Yii::$app->request->post()) && $newRegion= $addForm->create()){

            return $this->redirect(Url::toRoute(['view']));
        }

        return $this->render('add-region',['formItem'=>$addForm]);


    }






}