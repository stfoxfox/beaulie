<?php
/* @var $filter \common\models\CatalogCategoryFilter */
?>

<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="<1.5"<?= $filter->isChecked('<1.5') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>менее 1.5</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="1.5-1.95"<?= $filter->isChecked('1.5-1.95') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>1.5-1.95</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="2-2.45"<?= $filter->isChecked('2-2.45') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>2-2.45</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="2.5-2.99"<?= $filter->isChecked('2.5-2.99') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>2.5-2.99</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value=">3"<?= $filter->isChecked('>3') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>3 и более</span>
    </label>
</div>
