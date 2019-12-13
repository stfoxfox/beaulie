<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 23:46
 * @var \common\models\CatalogCategory $item
 */

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;
use common\models\Language;
use common\SharedAssets\FormColorPicker;
use backend\widgets\select2\Select2Widget;
use common\models\Department;

$languages = Language::getActive();
FormColorPicker::register($this);

?>


<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2><span class="text-success">Изменить</span></h2>

                <?php
                $form = ActiveForm::begin(['id'=>'add-category','options' => ['enctype' => 'multipart/form-data']]);
                ?>
                <p class="pull-right">
                    <a href="<?= Url::toRoute(['filter/view-category', 'id' => $item->id])?>">Управление группами фильтров</a> |
                    <a href="<?= Url::toRoute(['edit-attributes', 'id' => $item->id])?>">Управление атрибутами</a> | 
                    <a href="<?= Url::toRoute(['edit-styling', 'id' => $item->id])?>">Управление укладкой и уходом</a>
                </p>
                <div class="clearfix"></div>

                <ul class="nav nav-tabs">
                    <?php foreach ($languages as $language): ?>
                        <li<?= Language::isRussian($language) ? ' class="active"' : '' ?>><a data-toggle="tab" href="#<?=$language?>"><?= $language ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <br />
                <div class="tab-content">
                    <?php foreach ($languages as $language): ?>
                        <div id="<?= $language ?>" class="tab-pane fade in<?= Language::isRussian($language) ? ' active' : '' ?>">
                            <?= $form->field($formItem, 'title_' . $language)->textInput()->label('Заголовок') ?>
                            <?= $form->field($formItem, 'description_' . $language)->textarea()->label('Подробности') ?>
                            <?= $form->field($formItem, 'business_description_' . $language)->textarea()->label('Подробности для бизнеса') ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                

                <?= $form->field($formItem, 'business_color')->textInput(['class' => 'color_picker']) ?>
                <?= $form->field($formItem, 'home_color')->textInput(['class' => 'color_picker']) ?>

                <?=\backend\widgets\crop\CropImageWidget::widget([

                        'form'=>$formItem,
                        'fileAttribute'=>'file_name',
                        'model'=>$item->file,
                        'related_model_path'=>\common\models\CatalogCategory::tableName(),
                        'ratio'=>0
                    ]


                )?>

                <?=\backend\widgets\crop\CropImageWidget::widget([

                        'form'=>$formItem,
                        'fileAttribute'=>'business_file_name',
                        'model'=>$item->businessFile,
                        'related_model_path'=>\common\models\CatalogCategory::tableName(),
                        'ratio'=>0
                    ]


                )?>

                <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>

