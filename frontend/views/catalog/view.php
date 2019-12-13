<?php
/* @var $collection \common\models\Collection */
/* @var $items \common\models\CatalogItem[] */
/* @var $category \common\models\CatalogCategory */
/* @var $is_home boolean */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
use common\models\Language;
use common\models\Attribute;
use frontend\models\Favorites;
$asset = \frontend\assets\AppAsset::register($this);

$this->title = $category->title . ' / ' . $collection->title;
?>
<main class="page page_inner">
    <div class="page-layout page-layout_size_2">
        <div class="banner banner_thin banner_brown" style="background: <?= $category->home_color ?>;">
            <a class="banner__back" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => true]) ?>"></a>
            <div class="banner__title"><?= $category->title ?></div>
        </div>
        <div class="breadcrumbs">
            <div class="breadcrumbs__main">
                <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => $is_home])?>"><?= $category->title ?></a>/
                <?php if ($is_home): ?>
                    <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => true])?>"><?= Yii::t('app.catalog.breadcrumbs', 'Для себя')?></a>/
                <?php else: ?>
                    <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id])?>"><?= Yii::t('app.catalog.breadcrumbs', 'Для бизнеса')?></a>/
                <?php endif; ?>
                <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => $is_home])?>"><?= Yii::t('app.catalog.breadcrumbs', 'Все коллекции')?></a>/
                <span class="breadcrumbs__item"><?= $collection->title ?></span>
            </div>
            <span class="breadcrumbs__item">Количество товаров: <?= count($items) ?></span>
        </div>

        
        <div class="catalog js-widget" onclick="return {catalog: {}}">
            <div class="catalog__aside">
                <div class="catalog__header">
                    <div class="catalog__title"> <span class="catalog__title-wrap"><?= $collection->title ?></span></div>
                </div>
                <div class="catalog__info">
                    <div class="desc">
                        <?php foreach($collection->getCategoryAttributesAsArray($category->id, ['show_in_collection' => true]) as $attributeModel): ?>
                            <div class="desc__item">
                                <?= $attributeModel['title'] ?>: <?= implode(', ', $attributeModel['values']) ?>
                                <?= $attributeModel['type'] === Attribute::TYPE_NUMBER ? $attributeModel['measure'] : ''?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="catalog__palette palette palette_type_2">
                        <?php foreach($collection->getCategoryAttributesAsArray($category->id, ['show_collection_icon' => true]) as $attributeModel): ?>
                            <?php if (isset($attributeModel['icon_path'])): ?>
                            <span class="palette__item has-tip" title="<?= $attributeModel['icon_label'] ?>">
                                <img src="<?= Url::base() . '/' . $attributeModel['icon_path'] ?>" alt="<?= $attributeModel['icon_label'] ?>" />
                            </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <button class="catalog__tech btn btn_gray js-widget" type="button" onclick="return {showTechInfo: {}}"><?= mb_strtoupper(Yii::t('app.catalog.view', 'Технические характеристики')) ?></button>
                    </div>
<!--                    <div><a class="link link_gray popup-opener" href="#view-list-popup">отправить на e-mail</a></div>-->
                </div>
            </div>
            <div class="catalog__main">
                <div class="catalog__tech-info tech-info js-widget" onclick="return {techInfo : {}}">
                    <div class="tech-info__close"></div>
                    <table class="stackable">
                        <colspan>
                            <col width="70%">
                            <col width="30%">
                        </colspan>
                        <thead>
                        <tr>
                            <td><?= mb_strtoupper(Yii::t('app.catalog.view', 'Технические данные')) ?></td>
                            <td><?= mb_strtoupper(Yii::t('app.catalog.view', 'Значение')) ?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($collection->getCategoryAttributesAsArray($category->id, ['show_in_list' => true]) as $attributeModel): ?>
                            <tr>
                                <td><?= $attributeModel['title'] ?> <?= !is_null($attributeModel['standard']) ? $attributeModel['standard'] : '' ?></td>
                                <td><?= implode(', ', $attributeModel['values']) . (!empty($attributeModel['measure']) ? " {$attributeModel['measure']}" : '') ?> </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="2">Указанный срок службы линолеума ПВХ действителен для бытовых помещений при соблюдении соответствия покрытия классу помещений и выполнении требований инструкции по подготовке основания, укладке и уходу.
                                <br><br>Изображения дизайнов могут отличаться от реальных образцов продукции в связи с особенностями цветопередачи мониторов ПК, а также экранов иных устройств.
                                <?php if (
                                    mb_strtolower($category->title_ru) === 'линолеум пвх'
                                ){ ?>

                                    <br><br>Допустимые отклонения по толщине, весу квадратного метра и толщине защитного слоя в соответствии с ТУ завода-изготовителя не превышают +/- 10%.
                                <?php } ?>

                            </td>


                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="catalog__inner">
                    <div class="catalog__wrap">
                        <?php foreach ($items as  $key => $catalogItem): ?>
                            <div class="catalog__item">
                                <div class="catalog__item-wrap">
                                    <a class="product-card js-widget" onclick="return {productCard: {id: <?= $catalogItem->id ?>}}">
                                        <span class="product-card__fav<?= Favorites::isInFavorites($catalogItem->id) ? ' product-card__fav_active' : ''?>" data-id="<?= $catalogItem->id ?>">
                                            <svg>
                                                <use xlink:href="#icon-fav"></use>
                                            </svg>
                                            <svg class="_active">
                                                <use xlink:href="#icon-fav-active"></use>
                                            </svg>
                                        </span>
                                        <div class="product-card__image">
                                            <img src="<?= $catalogItem->file ? (new MyImagePublisher($catalogItem->file))->MyThumbnail(240, 240, 'file_name', 'catalog_item') : ''?>">
                                            <?php if ($catalogItem->is_new): ?>
                                                <div class="product-card__label product-label product-label_green"><?= Yii::t('app.catalogItem.label', 'New') ?></div>
                                            <?php endif; ?>
                                            <?php if ($catalogItem->is_hit): ?>
                                                <div class="product-card__label product-label"><?= Yii::t('app.catalogItem.label', 'Хит') ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-card__desc">
                                            <div class="product-card__title"><?= $catalogItem->title ?></div>
                                            <div class="product-card__text"><?= $catalogItem->description ?></div>
                                        </div>
                                    </a>
                                    <div class="product-info js-widget" onclick="return { productInfo: { id: <?= $catalogItem->id ?>} }" data-id="<?= $catalogItem->id ?>">
                                        <div class="product-info__wrap">
                                            <?php $gallery = $catalogItem->getFiles()->orderBy('sort')->all(); ?>
                                            <div class="product-info__left">
                                                <div class="product-info__image">
                                                    <?php if ($catalogItem->file): ?>
                                                        <div>
                                                            <a class="product-info__show-full" href="<?=(new MyImagePublisher($catalogItem->file))->resizeInBox(600, 400, false, 'file_name', 'catalog_item')?>"></a>
                                                            <img src="<?=(new MyImagePublisher($catalogItem->file))->MyThumbnail(400, 400, 'file_name', 'catalog_item')?>">
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($gallery)): ?>
                                                        <?php foreach($gallery as $image): ?>
                                                            <div>
                                                                <a class="product-info__show-full" href="<?=(new MyImagePublisher($image))->resizeInBox(600, 400, false, 'file_name', 'catalog_item')?>"></a>
                                                                <img src="<?=(new MyImagePublisher($image))->MyThumbnail(400, 400, 'file_name', 'catalog_item')?>">
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="product-info__slides">
                                                    <?php if ($catalogItem->file): ?>
                                                        <div class="product-info__slides-item">
                                                            <img src="<?=(new MyImagePublisher($catalogItem->file))->MyThumbnail(100, 100, 'file_name', 'catalog_item')?>">
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($gallery)): ?>
                                                        <?php foreach($gallery as $image): ?>
                                                            <div class="product-info__slides-item">
                                                                <img src="<?=(new MyImagePublisher($image))->MyThumbnail(100, 100, 'file_name', 'catalog_item')?>">
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="product-info__right">
                                                <div class="product-info__article"><?= Yii::t('app.catalog.view', 'Код товара: {code}', ['code' => $catalogItem->ext_code])?></div>
                                                <div class="product-info__title">
                                                    <span class="product-info__title-wrap"><?= $catalogItem->title ?></span>
                                                    <?php if ($catalogItem->is_hit): ?>
                                                        <div class="product-label"><?= Yii::t('app.catalogItem.label', 'Хит') ?></div>
                                                    <?php endif; ?>
                                                    <?php if ($catalogItem->is_new): ?>
                                                        <span class="product-label product-label_green"><?= Yii::t('app.catalogItem.label', 'New') ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="product-info__desc desc">
                                                    <?php foreach($catalogItem->getCategoryAttributes($category->id, ['show_in_catalog_item' => true]) as $attributeModel): ?>
                                                        <?php $value = $attributeModel->getValueFor($catalogItem, Language::current()); ?>
                                                        <?php if (!empty($value)): ?>
                                                            <div class="desc__item"><?= $attributeModel->title ?>: <?= $value ?></div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php if ($catalogItem->min_price && $catalogItem->max_price): ?>
                                                        <div class="desc__item">
                                                            <?= Yii::t('app.catalog.view', 'Диапазон цен: {min} - {max} &#8381;', [
                                                                'min' => $catalogItem->min_price, 'max' => $catalogItem->max_price
                                                            ]) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <button class="product-info__btn btn <?= Favorites::isInFavorites($catalogItem->id) ? 'product-info__btn_remove btn_black' : 'btn_red' ?>" type="button" data-id="<?= $catalogItem->id ?>">
                                                    <span class="btn__icon btn__icon_fav">
                                                    <svg class="fav-main">
                                                        <use xlink:href="#icon-fav"></use>
                                                    </svg>
                                                    <svg class="fav-active">
                                                        <use xlink:href="#icon-fav-active"></use>
                                                    </svg>
                                                    <svg class="fav-active_white">
                                                        <use xlink:href="#icon-fav-active-white"></use>
                                                    </svg>
                                                    </span>
                                                    <span class="product-info__btn-text">
                                                        <?= Favorites::isInFavorites($catalogItem->id) ?  mb_strtoupper(Yii::t('app.catalog.view', 'Убрать из избранного'))  : mb_strtoupper(Yii::t('app.catalog.view', 'Сохранить товар')) ?>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php if ($collection->page): ?>
    <?= $this->render('@frontend/views/common/_pageBlocks', ['page' => $collection->page]) ?>
<?php endif; ?>

    <div style="display: none;">
        <div class="popup popup_fav-list js-widget" id="view-list-popup">
            <div class="popup__inner">
                <div class="popup__title">
                <span class="popup__title-icon">
                    <svg>
                        <use xlink:href="#icon-fav-active"></use>
                    </svg>
                </span>
                    <span><?= $this->title ?> (<?= count($items) ?>)</span>
                </div>
                <form class="form popup__form" action="<?= Url::toRoute(['catalog/view', 'collection_id' => $collection->id])?>" method="post">
                    <div class="form__field">
                        <input name="name" class="form__input" type="text" required>
                        <label class="form__label">Имя</label>
                    </div>
                    <div class="form__field">
                        <input name="phone" class="form__input input_phone" type="text" required>
                        <label class="form__label">Телефон</label>
                    </div>
                    <div class="form__field">
                        <input name="email" class="form__input input_mail" type="text" required>
                        <label class="form__label">E-mail</label>
                    </div>
                    <div class="form__field">
                        <textarea name="message" class="form__input form__textarea" required rows="7"></textarea>
                        <label class="form__label">Сообщение</label>
                    </div>
                    <div class="form__field">
                        <button class="btn btn_red btn_full-width">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
        <?php if ($flash = Yii::$app->session->getFlash('success')): ?>
            <div class="popup popup_thanks" id="thanks-popup-3">
                <div class="popup__grid">
                    <div class="popup__image" style="background-image: url(<?= $asset->baseUrl ?>/images/content/popup-1.jpg);"></div>
                    <div class="popup__main">
                        <div class="popup__title">Ура-Ура!</div>
                        <div class="popup__text">
                            <?= $flash ?>
                        <div class="additional">
                            <div class="additional__text">Если у вас ещё остались вопросы по нашей продукции, мы всегда рады помочь вам:</div>
                            <div class="additional__links"><a class="link" href="mailto:info.juteksrussia@bintg.com">info.juteksrussia@bintg.com</a><br><span class="additional__phone">+ 7 (495) 365 65 55</span></div>
                            <button class="btn" type="button" onclick="$.magnificPopup.close()">Вернуться в каталог</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->registerJs('
              $.magnificPopup.open({
                items: {
                  src: "#thanks-popup-3"
                }
              });
            ', \yii\web\View::POS_END); ?>
        <?php endif; ?>

    </div>
<?php if ($flash = Yii::$app->session->getFlash('success')): ?>
    <?php $this->registerJs('
      $.magnificPopup.open({
        items: {
          src: "#thanks-popup-3"
        }
      });
    ', \yii\web\View::POS_END); ?>
<?php endif; ?>