<?php

use backend\assets\custom\EditDepartmentAsset;
use backend\assets\custom\EditRestaurantAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */





EditDepartmentAsset::register($this);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyAA_6Gr80xE2fpRLomSbMY1cTV7d7Ya794&v=3.exp&amp;sensor=false',[ 'depends' => 'backend\assets\custom\EditDepartmentAsset' ]);


?>
    <div class="row">
        <div class="col-md-4"><div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Магазин</h5>

                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $form = ActiveForm::begin(['id' => 'add-restaurant', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                            <div class="form-group"><label>Адрес ресторана</label>
                                <?=  $form->field($formItem, 'title')->textInput();?>

                                <?=  $form->field($formItem, 'phone')->textInput();?>
                                <?=  $form->field($formItem, 'phone_2')->textInput();?>
                                <?=  $form->field($formItem, 'site_url')->textInput();?>
                                <?=  $form->field($formItem, 'is_active')->checkbox();?>
                                <?=  $form->field($formItem, 'address')->textInput();?>
                                <?=  $form->field($formItem, 'lat')->textInput();?>
                                <?=  $form->field($formItem, 'lng')->textInput();?>

                                <?= $form->field($formItem, 'searchTitle',array('enableLabel'=>false))->textInput([ 'id'=>"pac-input" ,'class'=>"controls", 'type'=>"text", 'placeholder'=>"Search Box"])?>
                                <?php


//                                echo Html::activeHiddenInput($formItem, 'lat'); //Field
//                                echo Html::activeHiddenInput($formItem, 'lng'); //Field



                                ?>



                                <div id="map" class="google-map"></div>

                            </div>


                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div></div>

    <div class="col-md-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Часы работы</h5>

            </div>
            <div class="ibox-content">

              
                <table class="table">
                    <thead>
                    <tr>
                        <th>День недели</th>
                        <th>Часы работы</th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    /**
                     * @var \common\models\WorkingDays $workingDay
                     */
                    foreach($workingDays as $workingDay) {

                        ?>

                        <tr>
                            <td><?=Yii::t('app/spot',"day_".$workingDay->weekday)?></td>
                            <td><a data-restaurant="<?=$workingDay->department_id?>" data-day="<?=$workingDay->weekday?>" href="#" class="rh-editable-start" id="rh-hours-start-<?=$workingDay->weekday?>"><?=$workingDay->getDepartmentHours()['hours']['start']?></a> - <a data-restaurant="<?=$workingDay->department_id?>" data-day="<?=$workingDay->weekday?>" class="rh-editable-stop" href="#" id="rh-hours-stop-<?=$workingDay->weekday?>"><?=$workingDay->getDepartmentHours()['hours']['stop']?></a></td>
                                  </tr>


                        <?php
                    } ?>

                    </tbody>
                </table>



            </div>
        </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>