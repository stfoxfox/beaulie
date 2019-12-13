<?php
/**
 * @var $model \common\widgets\shop\forms\ShopWidgetForm
 * @var $items \common\models\Department[]
 */
use yii\helpers\Url;
?>

<section class="page-section page-section_blue page-section_promo_3">
    <div class="page-layout">
        <h2 class="tac"><?= $model->title ?></h2>
        <div class="content-slider content-slider_near js-widget" onclick="return { contentSlider: { type: 'near'}}">
            <?php if (!empty($items)): ?>
                <?php /* @var $item \common\models\Department */?>
                <?php foreach ($items as $item): ?>
                    <div class="content-slider__slide near-card">
                        <div class="near-card__main">
                            <h5 class="tac near-card__title"><?= $item->title ?></h5>
                            <p class="tac"><?= $item->region->title . ', ' . $item->address ?></p>
                        </div>
                        <div class="near-card__bottom">
                            <a class="near-card__item near-card__item_phone" href="tel:<?= $item->phone ?>" tabindex="-1"><?= $item->phone ?></a>
                            <div class="near-card__item near-card__item_time"><?= $item->getWorkingHours() ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
