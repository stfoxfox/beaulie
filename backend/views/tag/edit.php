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
                                    <?= $form->field($formItem, 'title_' . $language)->textInput()->label('Название') ?>
                                </div>
                            <?php endforeach; ?>
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
</div>

<?php ActiveForm::end(); ?>



