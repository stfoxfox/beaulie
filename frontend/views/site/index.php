<?php
use common\models\SiteSettings;
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $page \common\models\Page */
$this->title = 'Главная';
$bundle = \frontend\assets\AppAsset::register($this);
$bGallery = SiteSettings::findOne(['text_key' => 'mainPageBusinessGallery']);
$hGallery = SiteSettings::findOne(['text_key' => 'mainPageHomeGallery']);
$currentCat = \common\models\CatalogCategory::getCurrent();
?>
<main class="page page_no-offset">
    <!--index promo-->
    <div class="index-promo js-widget" onclick="return {indexPromo: {}}">
        <div class="index-promo__wrap index-promo__wrap_active">
            <div class="index-promo__main">
                <div class="promo-slider">
                    <div class="slider js-widget" onclick="return {promoSlider: {}}">
                        <?php if (!empty($bGallery->files)): ?>
                            <?php foreach ($bGallery->files as $file): ?>
                                <div class="promo-slider__item">
                                    <div class="promo-slider__wrap" style="background-image: url(<?=(new MyImagePublisher($file))->resizeInBox(1600, 1200, false, 'file_name', 'site_settings')?>);"></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <a class="promo-slider__link"><span><?= Yii::t('app.index', 'Для бизнеса') ?></span><span><?= Yii::t('app.index', 'Я покупаю для бизнеса') ?></span>
                        <svg>
                            <use xlink:href="#arrow-next"></use>
                        </svg></a>
                </div>
            </div>
            <div class="index-promo__aside">
                <div class="index-promo__title"><?= SiteSettings::get('mainPageHomeHeader') ?></div>
                <div class="index-promo__text"><?= SiteSettings::get('mainPageHomeText') ?></div>
                <a href="<?= Url::toRoute(['catalog/index', 'id' => $currentCat->id, 'is_home' => true])?>" class="index-promo__link" type="button"><?= Yii::t('app.index', 'Перейти в каталог') ?></a>
            </div>
        </div>
        <div class="index-promo__wrap index-promo__wrap_reverse">
            <div class="index-promo__main">
                <div class="promo-slider">
                    <div class="slider js-widget" onclick="return {promoSlider: {}}">
                        <?php if (!empty($hGallery->files)): ?>
                            <?php foreach ($hGallery->files as $file): ?>
                                <div class="promo-slider__item">
                                    <div class="promo-slider__wrap" style="background-image: url(<?=(new MyImagePublisher($file))->resizeInBox(1600, 1200, false, 'file_name', 'site_settings')?>);"></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div><a class="promo-slider__link"><span><?= Yii::t('app.index', 'Для себя') ?></span><span><?= Yii::t('app.index', 'Я покупаю для себя') ?></span>
                        <svg>
                            <use xlink:href="#arrow-next"></use>
                        </svg></a>
                </div>
            </div>
            <div class="index-promo__aside">
                <div class="index-promo__title"><?= SiteSettings::get('mainPageBusinessHeader') ?></div>
                <div class="index-promo__text"><?= SiteSettings::get('mainPageBusinessText') ?></div>
                <a href="<?= Url::toRoute(['catalog/index', 'id' => $currentCat->id])?>" class="index-promo__link" type="button"><?= Yii::t('app.index', 'Перейти в каталог') ?></a>
            </div>
        </div>
    </div>
    <?= $this->render('@frontend/views/common/_pageBlocks', ['page' => $page]) ?>
</main>
