<?php
/* @var $filter \common\models\CatalogCategoryFilter */
$values = $filter->getValues();
asort($values);
if (!empty($values)):
if (count($values) > 5) {
    $chunks = array_chunk($values, 5, true);
}

$customFilterLists = [
    'Уровень цены' => 'price',
    'Толщина покрытия, мм' => 'coatingThickness',
    'Толщина транспарента, мм' => 'transparencyThickness',
    'Вес 1м², кг' => 'weight'
];
?>
<div class="filter__list">
    <?php if (
            mb_strtolower($filter->catalogCategory->title_ru) === 'линолеум пвх' &&
            in_array($filter->title, array_keys($customFilterLists))
        ): ?>
        <?= $this->render('customFilterLists/_' . $customFilterLists[$filter->title], ['filter' => $filter]); ?>
    <?php else: ?>
        <?php if (isset($chunks)): ?>
            <div class="filter__list filter__list_with-cols">
                <?php foreach ($chunks as $chunk): ?>
                <div class="filter__list-col">
                    <?php foreach($chunk as $value => $label): ?>
                        <div class="filter__item">
                            <label class="checkbox">
                                <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="<?= $value ?>"<?= $filter->isChecked($value) ? ' checked="checked"' : ''?>>
                                <span class="checkbox__icon"></span>
                                <span><?= $label ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
        <?php foreach($values as $value => $label): ?>
            <div class="filter__item">
                <label class="checkbox">
                    <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="<?= $value ?>"<?= $filter->isChecked($value) ? ' checked="checked"' : ''?>>
                    <span class="checkbox__icon"></span>
                    <span><?= $label ?></span>
                </label>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>