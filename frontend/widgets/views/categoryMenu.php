<?php
/* @var $items \common\models\CatalogCategory[] */
?>
<?php foreach($items as $item): ?>
    <a class="aside-nav__item" href="<?= $item->getUrl() ?>">
        <span><strong><?= $item->title ?></strong></span>
    </a>
<?php endforeach; ?>