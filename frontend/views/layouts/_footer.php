<?php use yii\helpers\Url; ?>
<footer class="main-footer">
    <div class="page-layout page-layout_no-max-width">
        <div class="main-footer__wrap">
            <div class="main-footer__item main-footer__item_copyright"><span>© 2017  Beaulieu</span><a href="http://www.bintg.com" target="_blank">www.bintg.com</a></div>
            <nav class="main-footer__item main-footer__item_nav">
                <div class="main-footer__link"><a href="<?= Url::toRoute(['company/index']) ?>">Компания</a></div>
<!--                <div class="main-footer__link"><a href="--><?php //= Url::toRoute(['brands/index']) ?><!--">Бренды</a></div>-->
                <div class="main-footer__link"><a href="<?= Url::toRoute(['shops/index']) ?>">Магазины</a></div>
                <div class="main-footer__link"><a href="<?= Url::toRoute(['career/index']) ?>">Карьера</a></div>
                <div class="main-footer__link"><a href="<?= Url::toRoute(['site/contact']) ?>">Контакты</a></div>
            </nav>
            <div class="main-footer__item main-footer__item_who-made"><span>Сайт сделал –</span><a class="pinkman" href="#"></a></div>
        </div>
    </div>
</footer>