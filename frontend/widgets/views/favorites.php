<?php
/* @var $items \common\models\CatalogItem[] */
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
?>
<div class="fav-list js-widget" onclick="return {favList: {}}">
    <div class="page-layout page-layout_size_2">
        <div class="fav-list__inner">
            <div class="fav-list__wrap fav-slider">
                <?php if (!empty($items)): ?>
                <?php foreach($items as $item): ?>
                    <div class="fav-list__item" data-id="<?= $item->id ?>">
                        <div class="product-card product-card_style_2 js-widget">
                            <span class="product-card__fav product-card__fav_active" data-id="<?= $item->id ?>">
                                <svg>
                                    <use xlink:href="#icon-fav"></use>
                                </svg>
                                <svg class="_active">
                                    <use xlink:href="#icon-fav-active"></use>
                                </svg>
                            </span>
                            <div class="product-card__image">
                                <a href="<?= $item->getViewUrl(null, true) ?>">
                                    <img src="<?= $item->file ? (new MyImagePublisher($item->file))->MyThumbnail(200, 200, 'file_name', 'catalog_item') : ''?>">
                                </a>
                            </div>
                            <a class="product-card__desc" href="<?= $item->getViewUrl(null, true) ?>">
                                <div class="product-card__title"><?= $item->title ?></div>
                                <div class="product-card__text"><?= $item->description ?></div>
                            </a>
                            <a class="product-card__remove" href="<?= Url::toRoute(['favorites/remove', 'id' => $item->id])?>" data-id="<?= $item->id ?>">
                                <?= Yii::t('app.favorites', 'Удалить') ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="fav-list__info"><span class="fav-list__close"></span>
                <div class="fav-list__title"><?= Yii::t('app.favorites', 'Сохраненное') ?></div>
                <div class="fav-list__count"><span><?= count($items) ?></span> <?= Yii::t('app.favorites', 'товаров') ?></div>
                <a class="fav-list__btn btn btn_black" href="<?= Url::toRoute(['favorites/index']) ?>">
                    <div class="btn__icon btn__icon_fav">
                        <svg>
                            <use xlink:href="#icon-fav"></use>
                        </svg>
                    </div><span><?= Yii::t('app.favorites', 'Сохраненное') ?></span>
                </a>
            </div>
        </div>
    </div>
</div>