<?php

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24/11/2016
 * Time: 00:32
 */
/* @var $this View */
/* @var $model \backend\models\forms\CatalogCategoryAttributeForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use common\models\Attribute;
?>

<?php $form = ActiveForm::begin(['id' => 'add-spot', 'class' => "m-t"]); ?>


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
                                    <?= $form->field($model, 'attribute_id')->dropDownList(Attribute::getList()) ?>

                                    <?= $form->field($model, 'show_in_collection')->checkbox() ?>
                                    <?= $form->field($model, 'show_in_list')->checkbox() ?>
                                    <?= $form->field($model, 'show_in_catalog_item')->checkbox() ?>
                                    <?= $form->field($model, 'show_collection_icon')->checkbox() ?>
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
        
    </div>
<?php ActiveForm::end(); ?>