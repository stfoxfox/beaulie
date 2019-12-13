<?php
/**
 * @var $model \common\widgets\text\forms\ScreenButtonWidgetForm
 */
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section">
    <div class="banner banner_blue">
        <div class="banner__main">
            <div class="banner__title"><?= $model->title ?></div>
            <div class="banner__text"><?= $model->text ?></div>
            <div class="banner__links"><a class="btn banner__btn" href="<?= $model->link ?>">Связаться</a></div>
        </div>
        <div class="banner__image" style="background-image: url(<?= (new MyImagePublisher($model))->resizeInBox(480,340,false,'image') ?>);"></div>
    </div>
</section>