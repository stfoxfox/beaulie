<?php
use common\models\SiteSettings;
use common\models\Region;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\widgets\CatalogItemSummary;
use frontend\widgets\CategoryMenuWidget;
?>
<aside class="aside-nav js-widget" onclick="return {asideNav: {}}">
    <div class="aside-nav__back"><?= Yii::t('app.aside', 'Назад') ?></div>
    <div class="aside-nav__main">
        <a class="company-logo aside-nav__logo" href="<?= Yii::$app->homeUrl ?>">
            Beaulieu <br> International <br> Group<img src="<?=$bundle->baseUrl ?>/images/beaulie.png">
        </a>
        <div class="aside-nav__inner">
            <?= CatalogItemSummary::widget([]) ?>
            <?= CategoryMenuWidget::widget([]) ?>
        </div>
        <div class="aside-nav__mobile">
            <div class="aside-nav__item aside-nav__item_region"><?= Region::getCurrent()->title ?></div>
            <div class="aside-nav__item aside-nav__item_lang">
                <a href="#">Рус</a>
                <a href="#">Eng</a>
            </div>
            <div class="aside-nav__item aside-nav__item_phone"><a href="tel:7(495)3656555">+ 7 (495) 365 65 55</a></div>
            <div class="aside-nav__item">
                <div class="aside-nav__link"><a href="<?= Url::toRoute(['company/index']) ?>"><?= Yii::t('app.menu_mobile', 'Компания') ?></a></div>
                <div class="aside-nav__link"><a href="<?= Url::toRoute(['shops/index']) ?>"><?= Yii::t('app.menu_mobile', 'Магазины') ?></a></div>
                <div class="aside-nav__link"><a href="<?= Url::toRoute(['career/index']) ?>"><?= Yii::t('app.menu_mobile', 'Карьера') ?></a></div>
                <div class="aside-nav__link"><a href="<?= Url::toRoute(['site/contact']) ?>"><?= Yii::t('app.menu_mobile', 'Контакты') ?></a></div>
            </div>
        </div>
        <div class="socials js-widget aside-nav__socials" onclick="return {socials: {}}">
            <?php if ($fb = SiteSettings::get('facebook')): ?>
            <a class="socials__item socials__item_fb" href="<?= $fb ?>">
                <svg>
                    <use xlink:href="#fb"></use>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ($vk = SiteSettings::get('vk')): ?>
            <a class="socials__item socials__item_vk" href="<?= $vk ?>">
                <svg>
                    <use xlink:href="#vk"></use>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ($instagram = SiteSettings::get('instagram')): ?>
            <a class="socials__item socials__item_ig" href="<?= $instagram ?>">
                <svg>
                    <use xlink:href="#instagram"></use>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ($in = SiteSettings::get('in')): ?>
            <a class="socials__item socials__item_in" href="<?= $in ?>">
                <svg>
                    <use xlink:href="#in"></use>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ($tw = SiteSettings::get('twitter')): ?>
            <a class="socials__item socials__item_tw" href="<?= $tw ?>">
                <svg>
                    <use xlink:href="#twitter"></use>
                </svg>
            </a>
            <?php endif; ?>
            <?php if ($telegram = SiteSettings::get('telegram')): ?>
            <a class="socials__item socials__item_tg" href="<?= $telegram ?>">
                <svg>
                    <use xlink:href="#telegram"></use>
                </svg>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="aside-nav__region">
        <div class="aside-nav__item">
            <div class="aside-nav__search">
                <div class="aside__region-search">
                    <input class="aside__search-field__input" type="text" placeholder="Введите город">
                </div>
            </div>
            <div class="aside-nav__search-error" style="display:none;"><?= Yii::t('app.aside.region', 'Город не найден') ?></div>
        </div>
        <div class="aside-nav__region-list">
        <?php foreach(Region::getList(4, ['popup' => true]) as $id => $title): ?>
            <div class="aside-nav__item">
                <a href="<?= Url::toRoute(['site/change-region', 'id' => $id]); ?>">
                    <?= Html::encode($title) ?>
                </a>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</aside>
<?php $this->registerJs("
if ($('.aside__search-field__input')) {

    // Сюда нужна подстановка языка в ссылку из кук. Как оно там работает отсюда не видно.
    var language = 'ru';

    // Надо передавать из бека такой ответ
    /*
        {\"name\": \"Махачкала\", \"id\": \"1\"},
        {\"name\": \"Карганда\", \"id\": \"2\"},
        {\"name\": \"Запара\", \"id\": \"3\"}
     */

    $('.aside__search-field__input').easyAutocomplete({
        ajaxSettings: {
            method: \"POST\",
            dataType: \"jsonp\"
        },
        url: \"/\" + language + \"/search/region.html\",
        // Адрес обработчика запросов
        placeholder: 'Введите город',
        minCharNumber: 3,
        listLocation: 'items',
        // Это нужно для теста поля(надо удалить)
        adjustWidth: false,
        // Управление шириной поля(не требуется)
        highlightPhrase: true,
        // Выделение фразы с запросом в выдаче
        list: {
            // СОБЫТИЕ ВЫБОРА ГОРОДА ИЗ СПИСКА
            onClickEvent: function onClickEvent(item) {
                console.log($('.search-field__input').val());
            }
        },
        // Шаблон пункта в списке. item - это элементы массива, а adminCode1 одно из свойств
        template: {
            type: \"custom\",
            method: function method(value, item) {
                // Надо раскомментировать
                return \"<a href='/\" + language + \"/site/change-region/\" + item.id + \".html'>\" + item.title + \"</a>\";
                //return \"<a href='\" + language + \"/site/change-region/\" + item.adminCode1 + \".html'>\" + item.adminName1 + \"</a>\";
            }
        },

        getValue: function getValue(element) {
            // Надо раскомментировать
            return element.title;
            //return element.adminName1;
        },

        // Здесь подготавливается запрос в бэкенд
        preparePostData: function preparePostData(data, inputPhrase) {
            return {
                q: inputPhrase // Это то, что ввёл пользователь в поле. Остальное можно удалить(надо для теста)
            }
        },

        theme: \"dark-glass\"
    });
}
", \yii\web\View::POS_END);