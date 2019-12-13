<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use common\models\Attribute;
use common\models\Language;
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
                                    <ul class="nav nav-tabs">
                                    <?php foreach ($languages as $language): ?>
                                        <li<?= Language::isRussian($language) ? ' class="active"' : '' ?>><a data-toggle="tab" href="#<?=$language?>"><?= $language ?></a></li>
                                    <?php endforeach; ?>
                                    </ul>
                                    <br />
                                    <div class="tab-content">
                                    <?php foreach ($languages as $language): ?>
                                        <div id="<?= $language ?>" class="tab-pane fade in<?= Language::isRussian($language) ? ' active' : '' ?>">
                                            <?= $form->field($model, 'title_' . $language)->textInput()->label('Заголовок') ?>
                                            <?= $form->field($model, 'subtitle_' . $language)->textInput()->label('Второй заголовок') ?>
                                            <?= $form->field($model, 'text_' . $language)->textarea()->label('Текст') ?>
                                            <?= $form->field($model, 'file')->fileInput()->label('Файл')?>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
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
                                <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>
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
                            'form' => $model,
                            'model'=>$item->image,
                            'fileAttribute' => 'image',
                            'related_model_path' => \common\models\Styling::tableName(),
                            // 'ratio' => 0
                        ]
                    )?>
                </div>                
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>