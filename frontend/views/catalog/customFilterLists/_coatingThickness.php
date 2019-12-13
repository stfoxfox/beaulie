<?php
/* @var $filter \common\models\CatalogCategoryFilter */
?>

<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="<2"<?= $filter->isChecked('<2') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>менее 2</span>
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
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="2.5-2.95"<?= $filter->isChecked('2.5-2.95') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>2.5-2.95</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="3.0-3.45"<?= $filter->isChecked('3.0-3.45') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>3.0-3.45</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value=">3.5"<?= $filter->isChecked('>4') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>3.5 и более</span>
    </label>
</div>
