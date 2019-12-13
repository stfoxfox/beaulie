<?php

use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;

$src = null;
if ($model->file_name) {
    $src = (new MyImagePublisher($model))->resizeInBox(480, 480);
}
?>

<section class="page-section page-section_gray_2">
    <div class="page-layout page-layout_size_2">
        <div class="content-row">
            <div class="content-row__col content-row__col_flex">
                <div class="content-row__wrap">
                    <h2><?= $model->title?></h2>
                    <p class="text text_size_2"><?= $model->text ?></p>
                </div>
                <div class="content-row__wrap news__buttons">
                <?php foreach($items as $item): ?>
                    <a class="btn" href="<?= Url::toRoute(['styling/view', 'id' => $item->id])?>"><?= $item->title?></a>                
                <?php endforeach ?>
                </div>
            </div>
            <div class="content-row__col fs-0">
                <img src="<?= $src ?>" data-pagespeed-url-hash="2811027258" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
            </div>
        </div>
    </div>
</section>