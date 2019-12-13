<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Language;

$languages = Language::getActive();
?>

<?php if(!isset($page_block)){ ?>
<div class="ibox page_block" id="n_<?=$added_id?>">
<?php }else{ ?>
<div class="ibox page_block" id="block_<?= $page_block->id ?>" sort-id="<?= $page_block->sort ?>" data-page-block-id="<?= $page_block->id ?>">
<?php } ?>
<?php $form = ActiveForm::begin(['id' => "form_n_{$added_id}",'action' =>['save-widget'], 'class'=>"m-t",  'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="ibox-title ui-sortable-handle">
        <h5><?= $class_name::getBlockName() ?></h5>
        <div class="ibox-tools">
            <?= Html::hiddenInput('model_class_name', $model->className()); ?>
            <?= Html::hiddenInput('widget_class_name', $class_name); ?>
            <?= Html::hiddenInput('page_id', $page_id); ?>
            <?= Html::hiddenInput('lang', $lang); ?>
            <?php if(isset($page_block)) echo Html::hiddenInput('page_block_id', $page_block->id); ?>
            <?= Html::submitButton('Сохранить', ['id'=>"save_btn_{$added_id}",'data-block-id'=>!isset($page_block)?"n_{$added_id}":"block_{$page_block->id}",'data-form_id'=>$added_id,'class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs save_btn', 'name' => 'add-exist-button']) ?>
            <a class="dell-block-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <ul class="nav nav-tabs">
            <?php foreach ($languages as $language): ?>
                <li<?= $language === $lang ? ' class="active"' : '' ?>><a class="edit-block-link" href="#" data-lang="<?=$language?>"><?= $language ?></a></li>
            <?php endforeach; ?>
        </ul>
        <br />
        <div class="tab-content">
            <div id="<?= $lang ?>" class="tab-pane fade in active">
                <?php
                $safeAttributes = $model->safeAttributes();
                if (empty($safeAttributes)) {
                    $safeAttributes = $model->attributes();
                }
                foreach ($model->attributes() as $attribute) {
                    if (in_array($attribute, $safeAttributes)) {
                        eval('echo '.$model->generateActiveField($attribute,$model).';');
                    }
                }
                ?>
            </div>
        </div>
        <hr>
    </div>
<?php ActiveForm::end(); ?>
<?php $this->registerJs('
var select2 = $("select.select2");
if (select2.length) {
    select2.select2();
}
'); ?>
<?php $this->registerCss('
.select2-container {
    display: block;
}
') ?>
</div>
