<?php
/* @var $this \yii\web\View */
/* @var $items \common\models\Department[] */
/* @var $region \common\models\Region */

use frontend\assets\AppAsset;
use yii\helpers\Url;

$asset = AppAsset::register($this);
$this->title = Yii::t('app', 'Магазины');
?>
<main class="page page_inner shops-page">
    <div class="page-layout page-layout_size_2">
        <div class="shops-page__header">
            <div class="page-title"><?= $region->title ?> (<?= count($items) ?>)</div>
        </div>
        <div class="shops-page__map">
            <div class="map" id="map"></div>
        </div>
        <h5>Выберите категорию</h5>
        <div class="filter-selector js-widget" onclick="return {filterSelector: {}}">
            <div class="filter-selector__main-row">
            <?php foreach($categories as $category): ?>
                <button class="btn filter-selector__btn" type="button" data-id="<?= $category->id?>"><?= $category->title_ru?></button>
            <?php endforeach ?>
            </div>
            
            <?php foreach($categories as $category): ?>
                <div class="filter-selector__row" data-id="<?= $category->id?>">
                    <div class="shops-page__info">
                    <?php foreach($category['departments'] as $item): ?>
                        <div class="shop-info-card">
                            <div class="shop-info-card__title"><?= $item->title ?></div>
                            <div class="shop-info-card__text"><?= $item->address ?></div>
                            <div class="shop-info-card__hours"><?= $item->getWorkingHoursByDays() ?></div>
                            <div class="shop-info-card__phone"><?= $item->phone ?><br><?= $item->phone_2 ?></div>
                            <div class="shop-info-card__link">
                                <a class="link link_black" href="<?= $item->getUrl() ?>"><?= $item->site_url?></a>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</main>

<?php $this->registerJs("
function initMap() {
  window.marker = null;

  function initialize() {
    var map = void 0;
    var moscow = new google.maps.LatLng(55.7522200, 37.6155600);
    var style = [{
      'featureType': 'road',
      'elementType': 'labels.icon',
      'stylers': [{ 'saturation': 1 }, { 'gamma': 1 }, { 'visibility': 'on' }, { 'hue': '#e6ff00' }]
    }, {
      'elementType': 'geometry', 'stylers': [{ 'saturation': -100 }]
    }];

    var mapOptions = {
      // SET THE CENTER
      center: moscow,

      // SET THE MAP STYLE & ZOOM LEVEL
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      zoom: 10,

      // SET THE BACKGROUND COLOUR
      backgroundColor: '#eeeeee',

      // REMOVE ALL THE CONTROLS EXCEPT ZOOM
      panControl: false,
      zoomControl: true,
      mapTypeControl: false,
      scaleControl: false,
      streetViewControl: false,
      overviewMapControl: false,
      zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL
      }
    };
    //CREATE A CUSTOM PIN ICON
    var marker_image = '".$asset->baseUrl."/images/icons/map-pin.svg';
    var pinIcon = new google.maps.MarkerImage(marker_image, null, null, null, new google.maps.Size(30, 30));

    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // SET THE MAP TYPE
    var mapType = new google.maps.StyledMapType(style, { name: 'Grayscale' });
    map.mapTypes.set('grey', mapType);
    map.setMapTypeId('grey');
", \yii\web\View::POS_END); ?>

<?php foreach($items as $k => $item): ?>
    <?php if ($item->lat && $item->lng): ?>
        <?php $this->registerJs("
        map.setCenter(new google.maps.LatLng({$item->lat}, {$item->lng}));
        var marker{$k} = void 0;
        marker{$k} = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng({$item->lat}, {$item->lng}),
            icon: pinIcon
        });

        var contentString{$k} = '{$item->bubbleHtml()}';
        var infoWindow{$k} = new google.maps.InfoWindow({
          content: contentString{$k}
        });

        marker{$k}.setMap(map);
        marker{$k}.addListener('click', function () {
          infoWindow{$k}.open(map, marker{$k});
        });
        ", \yii\web\View::POS_END); ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php $this->registerJs("
  }

  google.maps.event.addDomListener(window, 'load', initialize);
}

initMap();
", \yii\web\View::POS_END); ?>
