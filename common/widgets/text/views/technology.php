<?php
/**
 * @var $model \common\widgets\text\forms\TechnologyWidgetForm
 */

use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section page-section_brown page-section_promo">
    <div class="page-layout page-layout_no-mobile-offset">
        <h2 class="tac"><?= $model->title ?>:</h2>
        <div class="content-slider content-slider_tech js-widget" onclick="return { contentSlider: { type: 'tech'}}">
            <div class="content-slider__slide-wrap">
                <div class="content-slider__slide tech-card">
                    <div class="tech-card__image"><img src="<?= (new MyImagePublisher($model))->resizeInBox(512,512,false,'p1_image') ?>"></div>
                    <div class="tech-card__count">1</div>
                    <div class="tech-card__info"><?= $model->p1_text ?></div>
                </div>
            </div>
            <div class="content-slider__slide-wrap">
                <div class="content-slider__slide tech-card">
                    <div class="tech-card__image"><img src="<?= (new MyImagePublisher($model))->resizeInBox(512,512,false,'p2_image') ?>"></div>
                    <div class="tech-card__count">2</div>
                    <div class="tech-card__info"><?= $model->p2_text ?></div>
                </div>
            </div>
            <div class="content-slider__slide-wrap">
                <div class="content-slider__slide tech-card">
                    <div class="tech-card__image"><img src="<?= (new MyImagePublisher($model))->resizeInBox(512,512,false,'p3_image') ?>"></div>
                    <div class="tech-card__count">3</div>
                    <div class="tech-card__info"><?= $model->p3_text ?></div>
                </div>
            </div>
            <div class="content-slider__slide-wrap">
                <div class="content-slider__slide tech-card">
                    <div class="tech-card__image"><img src="<?= (new MyImagePublisher($model))->resizeInBox(512,512,false,'p4_image') ?>"></div>
                    <div class="tech-card__count">4</div>
                    <div class="tech-card__info"><?= $model->p4_text ?></div>
                </div>
            </div>
        </div>
    </div>
</section>