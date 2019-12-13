<?php
/**
 * @var $model \common\widgets\text\forms\PhotoBigSmallTextWidgetForm
 */

use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section">
    <div class="page-grid page-grid_half">
        <div class="page-grid__unit">
            <div class="page-title"><?= $model->title ?></div>
            <p class="text text_big"><?= $model->text ?></p>
            <p class="text"><img src="<?= (new MyImagePublisher($model))->resizeInBox(190,110,false,'image_small') ?>"></p>
        </div>
        <div class="page-grid__unit">
            <figure><img src="<?= (new MyImagePublisher($model))->resizeInBox(440,275,false,'image_big') ?>"></figure>
        </div>
    </div>
</section>
