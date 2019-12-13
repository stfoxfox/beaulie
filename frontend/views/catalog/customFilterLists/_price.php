<?php
/* @var $filter \common\models\CatalogCategoryFilter */
?>

<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="<300"<?= $filter->isChecked('<300') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>менее 300</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="300-399"<?= $filter->isChecked('300-399') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>300-399</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="400-499"<?= $filter->isChecked('400-499') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>400-499</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value=">500"<?= $filter->isChecked('>500') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>500 и более</span>
    </label>
</div>
