<?php
/* @var $data array */
/* @var $category \common\models\CatalogCategory */
use common\components\MyExtensions\MyImagePublisher;
use common\models\Attribute;
use frontend\models\Favorites;
use yii\helpers\Url;
?>
<?php if (!empty($data)): ?>
<div class="catalog catalog_no-flex js-widget" onclick="return {catalog: {}}">
    <div class="series-wrap">
        <?php foreach ($data as $series): ?>
            <div class="series">
                <div class="series__aside">
                    <div class="catalog__header">
                        <div class="catalog__title">
                            <span class="catalog__title-wrap"><?= $series['collection']->title ?></span>
                        </div>
                        <div class="catalog__info">
                            <div class="desc">
                            <?php foreach($series['collection']->getCategoryAttributesAsArray($category->id, ['show_in_collection' => true]) as $attributeModel): ?>
                                <div class="desc__item">
                                    <?= $attributeModel['title'] ?>: <?= implode(', ', $attributeModel['values']) ?>
                                    <?= $attributeModel['type'] === Attribute::TYPE_NUMBER ? $attributeModel['measure'] : ''?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="series__link">
                                <a class="link link_red" href="<?= Url::toRoute(['catalog/view', 'collection_id' => $series['collection']->id, 'is_home' => $is_home])?>"><?= mb_strtoupper(Yii::t('app.catalog', 'Смотреть коллекцию')) ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="series__main">
                    <div class="catalog__wrap">
                        <?php for ($i = 0; $i < 3; ++$i): ?>
                            <?php if (!isset($series['items'][$i])): ?>
                                <?php break; ?>
                            <?php endif; ?>
                            <div class="catalog__item">
                                <div class="catalog__item-wrap">
                                    <a class="product-card js-widget" href="<?= $series['items'][$i]->getViewUrl($is_home, true) ?>">
                                        <span class="product-card__fav<?= Favorites::isInFavorites($series['items'][$i]->id) ? ' product-card__fav_active' : ''?>" data-id="<?= $series['items'][$i]->id ?>">
                                            <svg>
                                                <use xlink:href="#icon-fav"></use>
                                            </svg>
                                            <svg class="_active">
                                                <use xlink:href="#icon-fav-active"></use>
                                            </svg>
                                        </span>
                                        <div class="product-card__image">
                                            <img src="<?= $series['items'][$i]->file ? (new MyImagePublisher($series['items'][$i]->file))->MyThumbnail(240, 240, 'file_name', 'catalog_item') : ''?>">
                                            <?php if ($series['items'][$i]->is_new): ?>
                                                <div class="product-card__label product-label product-label_green"><?= Yii::t('app.catalogItem.label', 'New') ?></div>
                                            <?php endif; ?>
                                            <?php if ($series['items'][$i]->is_hit): ?>
                                                <div class="product-card__label product-label"><?= Yii::t('app.catalogItem.label', 'Хит') ?></div>
                                            <?php endif; ?>
                                            <?php if ($series['items'][$i]->is_sale): ?>
                                                <div class="product-card__label product-label"><?= Yii::t('app.catalogItem.label', 'Sale') ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-card__desc">
                                            <div class="product-card__title"><?= $series['items'][$i]->title ?></div>
                                            <div class="product-card__text"><?= $series['items'][$i]->description ?></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
    <div class="catalog catalog_no-flex not-found not-found_catalog js-widget" onclick="return {catalog: {}}">
        <div class="not-found__title"><?= Yii::t('app.not_found', 'По вашему запросу ничего <br> не найдено') ?></div>
        <div class="not-found__text"><?= Yii::t('app.not_found', 'Попробуйте изменить параметры поиска') ?></div><span class="not-found__icon"></span>
    </div>
<?php endif; ?>
