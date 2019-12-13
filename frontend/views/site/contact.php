<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\Department;
use common\models\SiteSettings;

$this->title = Yii::t('app', 'Контакты');
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="page page_inner contacts-page">
    <div class="page-layout page-layout_size_2">
        <div class="page-title contacts-page__title"><?= strtoupper($this->title)?></div>
        <div class="contacts-page__inner">
            <div class="contacts-page__map">
                <div class="map" id="map"></div>
            </div>
            <div class="contacts-page__main">
                <div class="page-title contacts-page__title contacts-page__title_desktop"><?= strtoupper($this->title)?></div>
                <div class="contacts-page__form">
                    <div class="contacts-page__row">
                        <div class="contacts-page__col">
                            <h6>E-MAIL</h6>
                        </div>
                        <div class="contacts-page__col"><a class="link link_red" href="mailto:info.juteksrussia@bintg.com">info.juteksrussia@bintg.com</a></div>
                    </div>
                    <form class="contacts-page__row form" method="post">
                        <div class="contacts-page__col">
                            <h6><?= strtoupper(Yii::t('app', 'Обратная связь')) ?></h6>
                        </div>
                        <div class="contacts-page__col">
                            <div class="form__field">
                                <?= Html::activeTextInput($model, 'name', ['class' => 'form__input', 'required' => 'required']) ?>
                                <label class="form__label"><?= Yii::t('app', 'Имя') ?></label>
                            </div>
                            <div class="form__field">
                                <?= Html::activeTextInput($model, 'phone', ['class' => 'form__input input_phone', 'required' => 'required']) ?>
                                <label class="form__label"><?= Yii::t('app', 'Телефон') ?></label>
                            </div>
                            <div class="form__field">
                                <?= Html::activeTextInput($model, 'email', ['class' => 'form__input input_mail', 'required' => 'required']) ?>
                                <label class="form__label"><?= Yii::t('app', 'Email') ?></label>
                            </div>
<!--                            <div class="form__field">-->
<!--                                --><?php //Html::activeDropDownList($model, 'department', Department::getList(), [
//                                    'class' => 'select',
//                                    'data-placeholder' => Yii::t('app', 'Выбрать склад')
//                                ]) ?>
<!--                            </div>-->
                            <div class="form__field">
                                <?= Html::activeTextarea($model, 'message', ['class' => 'form__input form__textarea', 'required' => 'required', 'rows' => 7]) ?>
                                <label class="form__label"><?= Yii::t('app', 'Сообщение') ?></label>
                            </div>
                            <div class="form__field">
                                <button class="btn btn_red btn_full-width"><?= Yii::t('app', 'Отправить') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?php $this->registerJs("
    $.magnificPopup.open({
      items: {
        src: '#thanks-popup-2'
      }
    });
    "); ?>
<?php endif; ?>
<?php
$lat = SiteSettings::get('contactPageGmLat');
$lng = SiteSettings::get('contactPageGmLng');
$this->registerJs("
var gmLat = '{$lat}';
var gmLng = '{$lng}';



function initMap() {
  var map = void 0;
  var t = void 0;
  var n = new google.maps.LatLng(gmLat, gmLng);
  var s = s = [{
    featureType: \"road\",
    elementType: \"labels.icon\",
    stylers: [{
        saturation: 1
    }, {
        gamma: 1
    }, {
        visibility: \"on\"
    }, {
        hue: \"#e6ff00\"
    }]
  }, {
    elementType: \"geometry\",
    stylers: [{
        saturation: -100
    }]
  }];

  var r = new google.maps.InfoWindow({
    content: '<div class=\"bubble\"><div class=\"bubble-title\">г. Камешково, Владимирская область</div><p class=\"text bubble-text\">Дорожная ул. 10</p><p><a href=\"#\" class=\"link link_red\">info.juteksrussia@bintg.com</a></p></div>'
  });

  var l = {
    center: n,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    zoom: 10,
    backgroundColor: \"#eeeeee\",
    panControl: !1,
    zoomControl: !0,
    mapTypeControl: !1,
    scaleControl: !1,
    streetViewControl: !1,
    overviewMapControl: !1,
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.SMALL
    }
  };
  map = new google.maps.Map(document.getElementById(\"map\"), l);
  var c = new google.maps.StyledMapType(s, {
    name: \"Grayscale\"
  });
  var i = window.location.origin + \"/images/icons/map-pin.svg\";
  map.mapTypes.set(\"grey\", c), map.setMapTypeId(\"grey\");
  var icon = new google.maps.MarkerImage(i, null, null, null, new google.maps.Size(30, 30));

  t = new google.maps.Marker({
    position: n,
    map: map,
    icon: icon
  });

  t.addListener('click', function() {
    r.open(map, t)
  });
}

initMap();

"); ?>
