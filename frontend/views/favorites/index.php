<?php

/* @var $items \common\models\CatalogItem[] */
/* @var $attributes array */
/* @var $category \common\models\CatalogCategory */
/* @var $this \yii\web\View */
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\ArrayHelper;
use frontend\assets\AppAsset;

$asset = AppAsset::register($this);
$this->title = Yii::t('app.favorites', 'Избранное');
?>
<main class="page page_inner">
    <div class="page-layout page-layout_size_2 page-layout_no-max-width">
        <div class="fav-page">
            <div class="fav-page__title page-title page-title_with-icon"><?= Yii::t('app.favorites', 'Сохранённое')?> (<span><?= count($items) ?></span>)
                <div class="page-title__icon">
                    <svg>
                        <use xlink:href="#icon-fav-active"></use>
                    </svg>
                </div>
            </div><a class="popup-opener fav-page__send-btn btn" href="#fav-list-popup">Отправить на E-mail</a>
            <div class="fav-page__saved-list saved-list js-widget" onclick="return {savedList : {}}">
                <div class="saved-list__info">
                    <div class="drop-info"><?= Yii::t('app.favorites', 'Перетащите объекты, чтобы добавить к сравнению') ?><span class="drop-info__icon"></span></div>
                </div>
                <?php if (!empty($items)): ?>
                    <div class="saved-list__inner fav-slider">
                    <?php foreach ($items as $item): ?>
                        <div class="saved-list__item" data-id="<?= $item->id ?>"><a class="saved-list__remove" href="#" data-id="<?= $item->id ?>"></a>
                            <div class="saved-list__item-wrap" data-info='<?= $item->asJson($category->id, ArrayHelper::getColumn($attributes, 'id')) ?>'>
                                <div class="product-card product-card_style_2 product-card_style_2">
                                    <span class="product-card__fav product-card__fav_active" data-id="<?= $item->id ?>">
                                        <svg>
                                            <use xlink:href="#icon-fav"></use>
                                        </svg>
                                        <svg class="_active">
                                            <use xlink:href="#icon-fav-active"></use>
                                        </svg>
                                    </span>
                                    <div class="product-card__image"><img src="<?= $item->file ? (new MyImagePublisher($item->file))->MyThumbnail(300, 300, 'file_name', 'catalog_item') : ''?>">
<!--                                        <div class="product-card__label product-label product-label_black">Pro</div>-->
                                    </div>
                                    <a class="product-card__desc" href="#">
                                        <div class="product-card__title"><?= $item->title ?></div>
                                        <div class="product-card__text"><?= $item->description ?></div>
                                    </a>
                                    <a class="product-card__remove" data-id="<?= $item->id ?>" href="<?= Url::toRoute(['favorites/remove', 'id' => $item->id])?>">Удалить</a>
                                </div>
                            </div>
<!--                            <div class="saved-list__tech-info">-->
<!--                                <div class="saved-list__info-row"><span class="saved-list__title">Color:</span><span>644M</span></div>-->
<!--                                <div class="saved-list__info-row"><span class="saved-list__title">Product Type:</span><span>PLANKS</span></div>-->
<!--                                <div class="saved-list__info-row"><span class="saved-list__title">Design Type:</span><span>Tile</span></div>-->
<!--                                <div class="saved-list__info-row"><span class="saved-list__title">Tile or Plank Sizes:</span><span>612 x 306  mm</span></div>-->
<!--                            </div>-->
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="compare-table js-widget fav-page__compare-table" onclick="return {compareTable: {}}">
                <div class="compare-table__inner">
                    <div class="compare-table__add-more add-more">
                        <div class="add-more__icon"></div>
                        <div class="add-more__text">Добавить ячейку</div>
                    </div>
                    <table>
                        <thead>
                        <tr>
                            <td class="_empty">
                                <div class="compare-table__image compare-table__image_empty"><img src="<?= Url::base() ?>/images/empty-image.svg"></div>
                            </td>
                            <td class="_empty">
                                <div class="compare-table__image compare-table__image_empty"><img src="<?= Url::base() ?>/images/empty-image.svg"></div>
                            </td>
                        </tr>
                        <tr class="compare-table__title-row">
                            <td>
                                <div class="compare-table__name"></div>
                            </td>
                            <td>
                                <div class="compare-table__name"></div>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($attributes as $row): ?>
                            <tr class="compare-table__title-row">
                                <td colspan="5">
                                    <div class="compare-table__title"><?= $row['title'] ?>:</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="compare-table__row">&nbsp;</td>
                                <td class="compare-table__row">&nbsp;</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="compare-table__bottom">
                    <button class="compare-table__show-all link link_gray link_bold" type="button">Показать все параметры</button>
                </div>
            </div>
            <div class="fav-page__bottom">
                <a class="btn btn_black fav-page__bottom-btn popup-opener" href="#fav-list-popup">
                    <div class="btn__icon btn__icon_fav">
                        <svg>
                            <use xlink:href="#icon-fav"></use>
                        </svg>
                    </div>
                    <span>ОТПРАВИТЬ НА E-MAIL</span>
                </a>
            </div>
        </div>
    </div>
</main>

<div style="display: none;">
    <div class="popup popup_fav-list js-widget" id="fav-list-popup">
        <div class="popup__inner">
            <div class="popup__title">
                <span class="popup__title-icon">
                    <svg>
                        <use xlink:href="#icon-fav-active"></use>
                    </svg>
                </span>
                <span>Сохранённое (<?= count($items) ?>)</span>
            </div>
            <form class="form popup__form" action="<?= Url::toRoute(['favorites/index'])?>" method="post">
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
        <div class="popup popup_thanks" id="thanks-popup-1">
            <div class="popup__grid">
                <div class="popup__image" style="background-image: url(<?= $asset->baseUrl ?>/images/content/popup-1.jpg);"></div>
                <div class="popup__main">
                    <div class="popup__title">Ура-Ура!</div>
                    <div class="popup__text">
                        <?= $flash ?>
                    </div>
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
              src: "#thanks-popup-1"
            }
          });
        ', \yii\web\View::POS_END); ?>
    <?php endif; ?>
</div>
