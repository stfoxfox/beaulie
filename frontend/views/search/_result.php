<?php
use frontend\models\Favorites;
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
use common\models\CatalogCategory;
?>
<div class="main-search__results result-list">
    <?php if (empty($brands) && empty($collections) && empty($items)): ?>
        <div class="result-list__item">
            <div class="result-list__title"><?= Yii::t('app.main.search', 'По вашему запросу ничего не найдено') ?></div>
        </div>
    <?php else: ?>
        <?php if(!empty($brands)): ?>
            <div class="result-list__title"><?= mb_strtoupper(Yii::t('app.main.search', 'Бренды')) ?></div>
            <?php $brandLinks = [] ?>
            <?php foreach ($brands as $brand): ?>
                <?php $brandLinks[] = '<a class="result-list__text" href="'.Url::toRoute(['catalog/index', 'id' => CatalogCategory::getCurrent()->id, 'brand[]' => $brand->id, 'is_home' => true]).'">' . $brand->title . '</a>'; ?>
            <?php endforeach; ?>
            <?= implode(', ', $brandLinks); ?>
        <?php endif; ?>
        <?php if(!empty($collections)): ?>
            <?php $collectionLinks = [] ?>
            <div class="result-list__title"><?= mb_strtoupper(Yii::t('app.main.search', 'Коллекции')) ?></div>
            <?php foreach ($collections as $collection): ?>
                <?php $collectionLinks[] = '<a class="result-list__text" href="' . Url::toRoute(['catalog/view', 'collection_id' => $collection->id]) . '">' . $collection->title .'</a>'; ?>
            <?php endforeach; ?>
            <?= implode(', ', $collectionLinks); ?>
        <?php endif; ?>
        <?php if(!empty($items)): ?>
            <div class="result-list__title"><?= mb_strtoupper(Yii::t('app.main.search', 'Продукты')) ?></div>
            <div class="result-list__goods">
            <?php foreach ($items as $item): ?>
                <a class="product-card js-widget-inited" href="<?= $item->getViewUrl() ?>">
                <span class="product-card__fav<?= Favorites::isInFavorites($item->id) ? ' product-card__fav_active' : ''?>">
                      <svg>
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fav"></use>
                      </svg>
                      <svg class="_active">
                          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fav-active"></use>
                      </svg>
                </span>
                    <div class="product-card__image"><img src="<?= $item->file ? (new MyImagePublisher($item->file))->MyThumbnail(200, 200, 'file_name', 'catalog_item') : ''?>">
<!--                        <div class="product-card__label product-label">Sale</div>-->
                    </div>
                    <div class="product-card__desc">
                        <div class="product-card__title"><?= $item->title ?></div>
                        <div class="product-card__text"><?= $item->description ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>