<?php
use common\models\Region;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

$asset = AppAsset::register($this);
?>
<div style="display: none;">
    <div class="popup popup_region region-popup" id="region-popup">
        <div class="popup__inner">
            <div class="region-popup__title">ВЫБЕРИТЕ ГОРОД</div>
            <p>Найдите магазин рядом с вами и ознакомьтесь <br> с нашим полным ассортиментом</p>
            <div class="search-field region-popup__search">
                <input class="search-field__input" placeholder="Введите город">
                <button class="search-field__btn"></button>
            </div>
            <span class="search-field__error" style="display: none;">Город не найден</span>
            <div class="region-popup__links">
                <?php foreach(Region::getList(4, ['popup' => true]) as $id => $title): ?>
                    <a class="region-popup__link" href="<?= Url::toRoute(['site/change-region', 'id' => $id]); ?>">
                        <?= Html::encode($title) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="popup popup_thanks" id="thanks-popup-2">
        <div class="popup__grid">
            <div class="popup__image" style="background-image: url(<?= $asset->baseUrl ?>/images/content/popup-2.jpg);"></div>
            <div class="popup__main">
                <div class="popup__title">Спасибо!</div>
                <div class="popup__text">Мы свяжемся с вами в ближайшее время</div>
            </div>
        </div>
    </div>
</div>
<?php if (!isset(\Yii::$app->request->cookies[Region::COOKIE_NAME])): ?>
    <?php $this->registerJs('
      $.magnificPopup.open({
        items: {
          src: "#region-popup"
        }
      });
    ', \yii\web\View::POS_END); ?>
<?php endif; ?>
<?php $this->registerJs("
var language = 'ru';
$('.search-field__input').easyAutocomplete({
    ajaxSettings: {
        method: \"POST\",
        dataType: \"jsonp\"
    },
    url: \"/\" + language + \"/search/region.html\", // Адрес обработчика запросов
    placeholder: 'Введите город',
    minCharNumber: 3,
    listLocation: 'items', // Это нужно для теста поля(надо удалить)
    adjustWidth: false, // Управление шириной поля(не требуется)
    highlightPhrase: true, // Выделение фразы с запросом в выдаче
    list: {
        // СОБЫТИЕ ВЫБОРА ГОРОДА ИЗ СПИСКА
        onClickEvent: function (item) {
            console.log($('.search-field__input').val());
        }
    },
    // Шаблон пункта в списке. item - это элементы массива, а adminCode1 одно из свойств
    template: {
        type: \"custom\",
        method: function (value, item) {
            // Надо раскомментировать
           return \"<a href='/\" + language + \"/site/change-region/\" + item.id + \".html'>\" + item.title + \"</a>\"
        }
    },

    getValue: function (element) {
        // Надо раскомментировать
        // return element.name;
        return element.title;
    },

    // Здесь подготавливается запрос в бэкенд
    preparePostData: function (data, inputPhrase) {
        return {
            q: inputPhrase // Это то, что ввёл пользователь в поле. Остальное можно удалить(надо для теста)
        }
    }
});
", \yii\web\View::POS_END);