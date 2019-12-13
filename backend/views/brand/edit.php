<?php
/**
 * @var \yii\web\View $this
 * @var \backend\models\forms\BrandForm $formItem
 */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Language;
use common\models\CatalogCategory;
use backend\widgets\select2\Select2Widget;

$languages = Language::getActive();
?>


<?php $form = ActiveForm::begin(['id' => 'edit-brand', 'class' => 'm-t', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Изображения</h5>

                        </div>
                        <div class="ibox-content">

                            <?= $form->field($formItem, 'file_name')->fileInput()->label("Изменить логотип ")?>
                            <div class="m-t m-b text-center" id="image-div" >
                                <?= Html::img($item->file ? (new MyImagePublisher($item->file))->resizeInBox(300,300,false,'file_name', 'brand') : '#', ['alt' => $item->title]) ?>
                            </div>

                            <?= $form->field($formItem, 'brand_file_name')->fileInput()->label("Изменить изображение ")?>
                            <div class="m-t m-b text-center" id="image-div" >
                                <?= Html::img($item->file ? (new MyImagePublisher($item->brandFile))->resizeInBox(300,300,false,'file_name', 'brand') : '#', ['alt' => $item->title]) ?>
                            </div>

                            <?= $form->field($formItem, 'show_on_page')->checkbox() ?>
                        </div>
                        <div class="row m-t">
                            <div class="col-md-12">
                                <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>
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
                            <h5>Информация</h5>

                        </div>
                        <div class="ibox-content">
                            <div class="m-t m-b">
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
                                            <?= $form->field($formItem, 'about_' . $language)->textarea()->label('Подробности') ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?=
                                $form->field($formItem, 'tags')->widget(Select2Widget::className(), [
                                    'items' => CatalogCategory::getItemsForSelect(),
                                    'options' => [
                                        'multiple' => 'multiple',
                                        'class' => 'form-control m-r',
                                        "style" => 'width: 100%',
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>