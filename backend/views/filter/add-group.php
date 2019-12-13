<?php
/**
 * @var \yii\web\View $this
 * @var \backend\models\forms\CatalogCategoryFilterGroupForm $formItem
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Language;
use common\models\CatalogCategory;
$languages = Language::getActive();
?>


<?php $form = ActiveForm::begin(['id' => 'add-filter-group', 'class' => 'm-t']); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Категория</h5>
                        </div>
                        <div class="ibox-content">
                            <?= $form->field($formItem, 'catalog_category_id')->dropDownList(CatalogCategory::getItemsForSelect())?>
                            <?= $form->field($formItem, 'is_quick_filter')->checkbox()?>
                            <?= $form->field($formItem, 'is_home')->checkbox()?>
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
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>