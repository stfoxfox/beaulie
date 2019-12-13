<?php

use backend\assets\custom\DepartmentFormAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */



DepartmentFormAsset::register($this);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyBHBzaWJmcud62yQFz9VitCyFbnp2YDkGU&libraries=places&callback=initMap&language=en',[ 'depends' => 'backend\assets\custom\DepartmentFormAsset' ]);


?>
    <div class="row">
        <div class="col-md-8"><div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Магазин</h5>

                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                            <div class="form-group">

                                <?=  $form->field($formItem, 'title')->textInput();?>

                                <?=  $form->field($formItem, 'phone')->textInput();?>
                                <?=  $form->field($formItem, 'phone_2')->textInput();?>
                                <?=  $form->field($formItem, 'site_url')->textInput();?>
                                <?=  $form->field($formItem, 'is_active')->checkbox();?>
                                <?=  $form->field($formItem, 'address')->textInput();?>
                                <?= $form->field($formItem, 'searchTitle',array('enableLabel'=>false))->textInput([ 'id'=>"pac-input" ,'class'=>"controls", 'type'=>"text", 'placeholder'=>"Search Box"])?>
                                <?php


                                echo Html::activeHiddenInput($formItem, 'lat'); //Field
                                echo Html::activeHiddenInput($formItem, 'lng'); //Field



                                ?>



                                <div id="map" class="google-map"></div>

                            </div>


                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Next step', ['class' => 'btn btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div></div>
        <div class="col-md-4"><div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Additional info</h5>

                </div>
                <div class="ibox-content">


                </div>
            </div></div>
    </div>

<?php ActiveForm::end(); ?>