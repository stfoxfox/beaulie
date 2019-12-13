<?php
/**
 * @var $model \common\widgets\text\forms\ScreenPhotoLeftWidgetForm
 */

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
?>

<section class="page-section">
    <div class="banner banner_brown">
        <div class="banner__main">
            <div class="banner__title"><?= $model->title ?></div>
            <div class="banner__text"><?= $model->text ?></div>
        </div>
        <div class="banner__image" style="background-image: url(<?= (new MyImagePublisher($model))->resizeInBox(480,340,false,'image') ?>);"></div>
    </div>
</section>