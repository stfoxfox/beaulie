<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21/06/2017
 * Time: 19:15
 *
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\SharedAssets\FormColorPicker;
use common\models\Language;

$languages = Language::getActive();
FormColorPicker::register($this);
?>


<?php $form = ActiveForm::begin(['id' => 'edit-page', 'class' => 'm-t', 'options' => ['enctype' => 'multipart/form-data']]); ?>


<div class="row">

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Основная информация</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <?php foreach ($languages as $language): ?>
                                        <li<?= Language::isRussian($language) ? ' class="active"' : '' ?>><a data-toggle="tab" href="#<?=$language?>-1"><?= $language ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <br />
                                <div class="tab-content">
                                    <?php foreach ($languages as $language): ?>
                                        <div id="<?= $language ?>-1" class="tab-pane fade in<?= Language::isRussian($language) ? ' active' : '' ?>">
                                            <?= $form->field($formItem, 'title_' . $language)->textInput()->label('Заголовок') ?>
                                            <?= $form->field($formItem, 'description_' . $language)->textarea()->label('Описание') ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <?= $form->field($formItem, 'slug')->textInput() ?>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">
                            <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>

    <div class="col-md-8">




        <div class="row"><div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Контент</h5>

                    </div>
                    <div class="ibox-content">

                        <div class="m-t m-b">
                            <ul class="nav nav-tabs">
                                <?php foreach ($languages as $language): ?>
                                    <li<?= Language::isRussian($language) ? ' class="active"' : '' ?>><a data-toggle="tab" href="#<?=$language?>-2"><?= $language ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <br />
                            <div class="tab-content">
                                <?php foreach ($languages as $language): ?>
                                    <div id="<?= $language ?>-2" class="tab-pane fade in<?= Language::isRussian($language) ? ' active' : '' ?>">
                                        <?= $form->field($formItem, 'html_text_' . $language)->textarea()->label('HTML текст') ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                    <div class="ibox-title">
                        <h5>Баннер</h5>

                    </div>
                    <div class="ibox-content">

                        <div class="m-t m-b">
                            <?= \backend\widgets\crop\CropImageWidget::widget([
                                    'form' => $formItem,
                                    'model'=>$item->bannerFile,
                                    'fileAttribute' => 'file_name',
                                    'related_model_path' => \common\models\Page::tableName(),
                                    'ratio' => 0
                                ]
                            )?>
                            <?= $form->field($formItem, 'banner_color')->textInput(['class' => 'color_picker']) ?>

                            <ul class="nav nav-tabs">
                                <?php foreach ($languages as $language): ?>
                                    <li<?= Language::isRussian($language) ? ' class="active"' : '' ?>><a data-toggle="tab" href="#<?=$language?>-3"><?= $language ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <br />
                            <div class="tab-content">
                                <?php foreach ($languages as $language): ?>
                                    <div id="<?= $language ?>-3" class="tab-pane fade in<?= Language::isRussian($language) ? ' active' : '' ?>">
                                        <?= $form->field($formItem, 'banner_text_' . $language)->textarea()->label('Текст баннера') ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>


                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Блоки</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="m-t m-b" ><a href="<?=Url::toRoute(['blocks','id'=>$item->id])?>"?>Управление блоками страницы</a></div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>
<?php ActiveForm::end(); ?>



