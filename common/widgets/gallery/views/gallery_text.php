<?php
/**
 * @var $model \common\widgets\gallery\forms\GalleryTextWidgetForm
 * @var $images \common\models\File[]
 */
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section">
    <div class="page-grid">
        <div class="page-grid__unit">
            <div class="page-title page-title_size_1"><?= $model->title ?></div>
            <p class="subtitle"><?= $model->subtitle ?></p>
        </div>
        <?php if (!empty($images)): ?>
            <div class="page-grid__unit">
                <?php foreach ($images as $image): ?>
                    <p class="text text_big"><?= $image->description ?></p>
                    <figure><img src="<?=(new MyImagePublisher($image))->resizeInBox(500, 400, false, 'file_name','page_block')?>"></figure>
                    <hr>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
