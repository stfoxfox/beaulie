<?php

use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;

?>
<section class="page-section page-layout page-layout_size_2">
    <div class="content-row">
        <div class="content-row__col content-row__col_flex">
            <div class="content-row__wrap">
                <h2><?= $model->title?></h2>
                <p class="subtitle"><?= $model->text ?></p>
            </div>
            <div class="content-row__wrap"><a class="btn" href="<?= Url::to(['news/list']) ?>">Читать все новости</a></div>
        </div>
        <div class="content-row__col">
            <div class="content-list content-list_with-offset">
            <?php foreach($items as $item): ?>
                <div class="content-list__item">
                    <div class="content-list__image">
                        <img src="<?= (new MyImagePublisher($item->file))->resizeInBox(140, 140, false, 'file_name','news') ?>" data-pagespeed-url-hash="18313049" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                    </div>
                    <div class="content-list__info">
                        <div class="content-list__wrap">
                            <div class="content-list__header">
                            <?php foreach($item->catalogCategories as $category): ?>
                                <a class="content-list__link" href="<?= Url::to(['catalog/index', 'id' => $category->id])?>"><?= $category->title_ru ?></a>
                            <?php endforeach ?>

                            <?php foreach($item->tags as $tag): ?>
                                <span class="content-list__tag">#<?= $tag->title_ru?></span>
                            <?php endforeach ?>
                            </div>
                            <div class="content-list__title"><?= $item->title ?></div>
                        </div>
                        <div class="content-list__date"><?= date('j F Y', strtotime($item->created_at))?></div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </div>
    </div>
</section>