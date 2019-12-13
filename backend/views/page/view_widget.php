<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 29/06/2017
 * Time: 14:12
 *
 * @var \common\models\BlogPostBlock $model
 */
use backend\widgets\editable\EditableWidget;
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="ibox page_block" id="block_<?= $page_block->id ?>" sort-id="<?= $page_block->id ?>" data-page-block-id="<?= $page_block->id ?>">
    <div class="ibox-title">
        <h5 class=" ui-sortable-handle"><?= $class_name::getBlockName() ?>:</h5> <?=
        EditableWidget::widget([
            'name' => 'block_name',
            'value' => $page_block->block_name,
            'pk' => $page_block->id,
            'url' => ['block-editable'],
        ])
        ?>
        <div class="ibox-tools">
            <a class="edit-block-link">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="dell-block-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <table class="table">
            <thead>
              <tr>
                 <th>Параметр</th>
                 <th>Значение</th>
              </tr>
             </thead>
            <?php 
                $safeAttributes = $model->safeAttributes();
                if (empty($safeAttributes)) {
                    $safeAttributes = $model->attributes();
                }
                foreach ($model->attributes() as $attribute) {
                    if (in_array($attribute, $safeAttributes)) {
                        echo $model->generateActiveValue($attribute,$model,$page_block);
                    }
                }
            ?>
        </table>
    </div>
</div>
