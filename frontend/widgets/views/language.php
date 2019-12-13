<div class="lang-selector js-widget main-header__lang-selector" onclick="return {langSelector : {}}">
    <div class="lang-selector__current"><?= Yii::$app->language ?></div>
    <div class="lang-selector__dropdown">
        <?php foreach ($languages as $language): ?>
            <a href="/<?= $language ?>"><?= $language ?></a><br />
        <?php endforeach; ?>
    </div>
</div>