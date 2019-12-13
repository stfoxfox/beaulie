<?php
/* @var $this \yii\web\View */
/* @var $page \common\models\Page */
use common\components\MyExtensions\MyImagePublisher;

$this->title = $page->title;
?>
<main class="page page_inner news">
    <div class="page-layout page-layout_size_2">
        <div class="banner" style = "background: <?= $page->banner_color?>">
            <div class="banner__main">
                <div class="banner__title"><?= $page->title ?></div>
                <div class="banner__text"><?= $page->banner_text ?></div>
            </div>
            <div class="banner__image" style="<?= $page->bannerFile ? 'background-image' : 'background' ?>: <?= $page->bannerFile ? 'url(' . (new MyImagePublisher($page->bannerFile))->resizeInBox(450, 300, false, 'file_name', 'page') . ')': $page->banner_color ?>;"></div>
        </div>
    </div>
    <?= $this->render('@frontend/views/common/_pageBlocks', ['page' => $page]) ?>
</main>