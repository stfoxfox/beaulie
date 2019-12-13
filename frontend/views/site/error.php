<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\models\CatalogCategory;

$asset = AppAsset::register($this);
$categories = CatalogCategory::getItems(5);
$this->title = $name;
?>
<main class="page page_inner not-found">
    <div class="page-layout page-layout_size_2">
        <div class="not-found__wrap"><img class="not-found__image" src="<?=$asset->baseUrl?>/images/icons/404.svg">
            <div class="not-found__title"><?= $this->title ?></div>
            <div class="not-found__text"><?= nl2br(Html::encode($message)) ?> <br>  Вы можете перейти на главную страницу или воспользоваться <br>  каталогом товаров.</div>
            <div class="not-found__links">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <a class="link link_black" href="<?= $category->getUrl() ?>"><?= strtoupper($category->title) ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
