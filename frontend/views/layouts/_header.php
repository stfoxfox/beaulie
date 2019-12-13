<?php
use frontend\widgets\LanguageDropdown;
use common\models\Region;
use yii\helpers\Url;
use frontend\models\Favorites;
use common\components\MyExtensions\MyHelper;
?>
<header class="main-header">
    <div class="main-header__item">
        <?= LanguageDropdown::widget() ?>
        <a class="main-header__region popup-toggler" href="#region-popup"><?= Region::getCurrent()->title ?></a>
    </div>
    <div class="main-header__item main-header__nav">
        <div class="main-nav">
            <a class="main-nav__item<?= Yii::$app->controller->id === 'company' ? ' main-nav__item_active' : ''?>" href="<?= Url::toRoute(['company/index']) ?>"><?= Yii::t('app.menu', 'Компания') ?></a>
<!--            <a class="main-nav__item" href="--><?php //Url::toRoute(['brands/index']) ?><!--">--><?php //Yii::t('app.menu', 'Бренды') ?><!--</a>-->
            <a class="main-nav__item<?= Yii::$app->controller->id === 'shops' ? ' main-nav__item_active' : ''?>" href="<?= Url::toRoute(['shops/index']) ?>"><?= Yii::t('app.menu', 'Магазины') ?></a>
            <a class="main-nav__item<?= Yii::$app->controller->id === 'career' ? ' main-nav__item_active' : ''?>" href="<?= Url::toRoute(['career/index']) ?>"><?= Yii::t('app.menu', 'Карьера') ?></a>
            <a class="main-nav__item<?= Yii::$app->controller->action->id === 'contact' ? ' main-nav__item_active' : ''?>" href="<?= Url::toRoute(['site/contact']) ?>"><?= Yii::t('app.menu', 'Контакты') ?></a>
            <a class="main-nav__item<?= Yii::$app->controller->action->id === 'news' ? ' main-nav__item_active' : ''?>" href="<?= Url::toRoute(['news/index']) ?>"><?= Yii::t('app.menu', 'Новости и информация') ?></a>
        </div>
    </div>
    <div class="main-header__item">
        <a class="main-header__search" href="#">
            <svg class="_main">
                <use xlink:href="#icon-search"></use>
            </svg>
            <svg class="_hover">
                <use xlink:href="#icon-search-red"></use>
            </svg>
        </a>
        <a class="main-header__fav js-widget" href="<?= Url::to(['favorites/index'])?>" onclick="<?= MyHelper::isMobile() ? '' : 'return {favToggle: {}}' ?>">
            <span class="main-header__fav-count"><?= Favorites::count() ?></span>
            <svg>
                <use xlink:href="#icon-fav"></use>
            </svg>
        </a>
    </div>
</header>