<?php
/**
 * @var $items \common\models\Brand[]
 * @var $model \common\widgets\brand\forms\BrandsWidgetForm
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;
?>
<section class="page-section">
    <h2 class="tac"><?= $model->title ?></h2>
    <div class="content-slider content-slider_brands slider js-widget" onclick="return { contentSlider: { type: 'brands'}}">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <div class="content-slider__slide-wrap">
                    <a class="content-slider__slide" href="#">
                        <?= Html::img($item->file ? (new MyImagePublisher($item->file))->resizeInBox(150,150,false,'file_name', 'brand') : '#', ['alt' => $item->title_ru]) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <p class="tac"><a class="btn" href="<?= Url::toRoute(['brands/index']) ?>"><?= Yii::t('app', 'Все бренды') ?></a></p>
</section>