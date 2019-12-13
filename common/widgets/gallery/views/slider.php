<?php
/**
 * @var $model \common\widgets\gallery\forms\SliderWidgetForm
 * @var $images \common\models\File[]
 */

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
?>
<section class="page-section page-section_gray page-section_promo_2">
    <div class="page-layout page-layout_no-mobile-offset">
        <h2 class="tac"><?= $model->title ?>:</h2>
        <div class="content-slider content-slider_cert slider js-gallery js-widget" onclick="return { contentSlider: { type: 'cert'}}">
            <?php foreach ($images as $image): ?>
                <div class="content-slider__slide-wrap"><a class="content-slider__slide cert-card" href="<?=(new MyImagePublisher($image))->resizeInBox(1200, 1200, false, 'file_name','page_block')?>">
                <div class="cert-card__image">
                    <img src="<?=(new MyImagePublisher($image))->resizeInBox(500, 400, false, 'file_name','page_block')?>">
                </div>
                <div class="cert-card__text"><?= $image->title ?></div></a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($model->link): ?>
            <p class="tac"><a class="btn" href="<?= Url::to($model->link)?>"><?= Yii::t('app', 'Подробнее') ?></a></p>
        <?php endif; ?>
    </div>
</section>