<?php

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24/11/2016
 * Time: 00:32
 */
/* @var $this View */

use backend\assets\custom\ItemFormAsset;
use backend\widgets\select2\Select2Widget;
use common\models\CatalogCategory;
use common\models\CatalogItemModificator;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>

<?php $form = ActiveForm::begin(['id' => 'add-spot', 'class' => "m-t", 'options' => ['enctype' => 'multipart/form-data']]); ?>


<div class="row">

    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Основная информация</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">




                                <?= $form->field($formItem, 'title')->textInput() ?>
                                <?= $form->field($formItem, 'description')->textarea() ?>

                                <?php // $form->field($editForm, 'types',array())->dropDownList(\common\models\SpotType::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>

                                <?= $form->field($formItem, 'price')->textInput() ?>
                                <?= $form->field($formItem, 'old_price')->textInput() ?>
                                <?= $form->field($formItem, 'min_price')->textInput() ?>
                                <?= $form->field($formItem, 'max_price')->textInput() ?>
                                <?= $form->field($formItem, 'ext_code')->textInput() ?>


                                <?php


                                if ($formItem->parent_id){
                                    $formItem->categories[]=$formItem->parent_id;
                                }

                                echo $form->field($formItem, 'categories')->widget(Select2Widget::className(), [
                                    'items' => CatalogCategory::getItemsForSelect(),
                                    'options' => [
                                        'multiple' => 'multiple',
                                        'class' => 'form-control m-r',
                                        "style" => 'width: 100%',
                                    ],
                                ]);
                            ?>



                                <?= $form->field($formItem, 'is_active')->checkbox() ?>
                                <?= $form->field($formItem, 'is_new')->checkbox() ?>
                                <?= $form->field($formItem, 'is_hit')->checkbox() ?>
                                <?= $form->field($formItem, 'is_sale')->checkbox() ?>
                                <?= $form->field($formItem, 'is_home')->checkbox() ?>
                                <?= $form->field($formItem, 'is_business')->checkbox() ?>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">

                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">

    <div class="row">
        <div class="col-md-12">

            <?=\backend\widgets\crop\CropImageWidget::widget([

                    'form'=>$formItem,
                    'fileAttribute'=>'file_name',
                    'related_model_path'=>\common\models\CatalogCategory::tableName(),
                    'ratio'=>0
                ]


            )?>
        </div>
    </div>





    </div>


</div>
<?php ActiveForm::end(); ?>