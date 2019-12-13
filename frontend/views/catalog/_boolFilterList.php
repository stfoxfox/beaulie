<?php
/**
 * @var $filters \common\models\CatalogCategoryFilter[]
 */

if (count($filters) > 5) {
    $chunks = array_chunk($filters, 5, true);
}
?>
<?php if (!empty($filters)): ?>
<div class="filter__col">
    <div class="filter__title"><?= $filters[0]->title ?></div>
    <div class="filter__list">
        <?php if (isset($chunks)): ?>
            <div class="filter__list filter__list_with-cols">
                <?php foreach ($chunks as $chunk): ?>
                    <div class="filter__list-col">
                        <?php foreach($chunk as $filter): ?>
                            <div class="filter__item">
                                <label class="checkbox">
                                    <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox"<?= $filter->isChecked('on') ? ' checked="checked"' : ''?>>
                                    <span class="checkbox__icon"></span>
                                    <span><?= $filter->attributeModel->title ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
        <?php foreach ($filters as $filter): ?>
            <div class="filter__item">
                <label class="checkbox">
                    <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox"<?= $filter->isChecked('on') ? ' checked="checked"' : ''?>>
                    <span class="checkbox__icon"></span>
                    <span><?= $filter->attributeModel->title ?></span>
                </label>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
