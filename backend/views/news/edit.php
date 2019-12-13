<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Language;
use common\models\Tag;
use common\models\CatalogCategory;
use backend\widgets\select2\Select2Widget;

$languages = Language::getActive();
?>


<?php $form = ActiveForm::begin(['id' => 'add-news', 'class'=>"m-t", 'options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="row">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Основная информация</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
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
                                    <?= $form->field($formItem, 'text_' . $language)->textarea()->label('Описание') ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?= $form->field($formItem, 'tags')->widget(Select2Widget::className(), [
                            'items' => Tag::getList(),
                            'options' => [
                                'multiple' => 'multiple',
                                'class' => 'form-control m-r',
                                "style" => 'width: 100%',
                            ],
                        ])->label('Теги') ?>

                        <?= $form->field($formItem, 'catalog_categories')->widget(Select2Widget::className(), [
                            'items' => CatalogCategory::getItemsForSelect(),
                            'options' => [
                                'multiple' => 'multiple',
                                'class' => 'form-control m-r',
                                "style" => 'width: 100%',
                            ],
                        ])->label('Категории') ?>

                        <?=\backend\widgets\crop\CropImageWidget::widget([
                            'form'=>$formItem,
                            'fileAttribute'=>'file',
                            'model'=>$item->file,
                            'related_model_path'=>\common\models\News::tableName(),
                            'ratio'=>0
                        ])?>
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
</div>

<?php ActiveForm::end(); ?>



