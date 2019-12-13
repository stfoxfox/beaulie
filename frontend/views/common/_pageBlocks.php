<?php /* @var $page \common\models\Page */?>
<?php if (!empty($page->pageBlocks)): ?>
    <?php foreach ($page->pageBlocks as $key => $block): ?>
        <?= $block->dataWidget; ?>
    <?php endforeach; ?>
<?php endif; ?>