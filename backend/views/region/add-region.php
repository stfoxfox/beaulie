<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07.11.15
 * Time: 23:57
 */

use backend\assets\custom\CatalogAddCategoryAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;
use common\models\Country;

$this->title ='Добавить Регион';


?>



<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center p-md">



            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center p-md">

                <p>
                    <?php
                    $form = ActiveForm::begin(['id'=>'add-category']);
                    ?>
                    <?= $form->field($formItem, 'title',array())->textInput()->label(false) ?>
                    <?= $form->field($formItem, 'is_default')->checkbox()->label(false) ?>
                    <?= $form->field($formItem, 'popup')->checkbox()->label(false) ?>
                    <?= $form->field($formItem, 'country_id')->dropDownList(Country::getList())->label(false) ?>

                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>

            </div>
        </div>
    </div>

</div>

