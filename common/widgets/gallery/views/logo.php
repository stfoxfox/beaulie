<?php
/**
 * @var $model \common\widgets\gallery\forms\LogoWidgetForm
 * @var $images \common\models\File[]
 */
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section">
    <div class="page-grid">
        <div class="page-grid__unit">
            <div class="page-title page-title_size_1"><?= $model->title ?></div>
        </div>
        <div class="page-grid__unit">
            <p class="text text_big"><?= $model->text ?></p>
            <?php if (!empty($images)): ?>
                <div class="content-slider content-slider_brands-list brands-list js-widget" onclick="return { contentSlider: {type: 'brandList'}}">
                    <?php foreach ($images as $image): ?>
                        <div class="content-slider__slide-wrap">
                            <div class="brands-list__item">
                                <div class="brands-list__image"><img src="<?=(new MyImagePublisher($image))->resizeInBox(500, 400, false, 'file_name','page_block')?>" alt="<?= $image->title ?>"></div>
                                <div class="brands-list__text"><?= $image->title ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>