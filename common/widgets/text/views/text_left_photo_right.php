<?php
/**
 * @var $model \common\widgets\text\forms\TextLeftPhotoRightWidgetForm
 */

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section page-layout">
    <div class="info info_reverse">
        <div class="info__desc">
            <h2><?= $model->title ?></h2>
            <?= nl2br(Html::encode($model->text)) ?>
        </div>
        <div class="info__image"><img src="<?= (new MyImagePublisher($model))->resizeInBox(480,340,false,'image') ?>"></div>
    </div>
</section>