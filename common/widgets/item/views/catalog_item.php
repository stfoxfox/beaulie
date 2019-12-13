<?php
/* @var $model \common\widgets\item\forms\CatalogItemWidgetForm */
/* @var $items \common\models\CatalogItem[] */

use frontend\models\Favorites;
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section">
    <div class="content-slider content-slider_product js-widget" onclick="return { contentSlider: { type: 'product'}}">
        <?php foreach ($items as $item): ?>
            <div class="content-slider__slide-wrap">
                <a class="js-widget product-card content-slider__slide" href="<?= $item->getViewUrl() ?>">
                    <span class="product-card__fav<?= Favorites::isInFavorites($item->id) ? ' product-card__fav_active' : ''?>" data-id="<?= $item->id ?>">
                        <svg>
                            <use xlink:href="#icon-fav"></use>
                        </svg>
                        <svg class="_active">
                            <use xlink:href="#icon-fav-active"></use>
                        </svg>
                    </span>
                    <div class="product-card__image">
                        <img src="<?= $item->file ? (new MyImagePublisher($item->file))->MyThumbnail(300, 300, 'file_name', 'catalog_item') : '' ?>">
                        <?php if ($item->is_new): ?>
                            <div class="product-card__label product-label product-label_green"><?= Yii::t('app.catalogItem.label', 'New') ?></div>
                        <?php endif; ?>
                        <?php if ($item->is_hit): ?>
                            <div class="product-card__label product-label"><?= Yii::t('app.catalogItem.label', 'Хит') ?></div>
                        <?php endif; ?>
                        <?php if ($item->is_sale): ?>
                            <div class="product-card__label product-label"><?= Yii::t('app.catalogItem.label', 'Sale') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="product-card__desc">
                        <div class="product-card__title"><?= $item->title ?></div>
                        <div class="product-card__text"><?= $item->description ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>