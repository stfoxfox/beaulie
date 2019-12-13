<?php
/**
 * @var $model \common\widgets\text\forms\TextPhotoThreeTextWidgetForm
 */

use common\components\MyExtensions\MyImagePublisher;
?>

<section class="page-section page-section_gray_2">
    <div class="page-grid">
        <div class="page-grid__unit">
            <div class="page-title page-title_size_1"><?= $model->title ?></div>
        </div>
        <div class="page-grid__unit">
            <p class="text text_big"><?= $model->text ?></p>
            <figure><img src="<?= (new MyImagePublisher($model))->resizeInBox(480,340,false,'image') ?>"></figure>
            <ul class="list list_cols">
                <li class="list__item"><?= $model->p1_text ?></li>
                <li class="list__item"><?= $model->p2_text ?></li>
                <li class="list__item"><?= $model->p3_text ?></li>
            </ul>
        </div>
    </div>
</section>
