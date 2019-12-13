<?php
/* @var $filter \common\models\CatalogCategoryFilter */
?>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="<0.2"<?= $filter->isChecked('<0.2') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>менее 0.2</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="0.2-0.29"<?= $filter->isChecked('0.2-0.29') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>0.2-0.29</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="0.3-0.39"<?= $filter->isChecked('0.3-0.39') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>0.3-0.39</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value="0.4-0.49"<?= $filter->isChecked('0.4-0.49') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>0.4-0.49</span>
    </label>
</div>
<div class="filter__item">
    <label class="checkbox">
        <input name="<?= $filter->getInputName() ?>" class="checkbox__input" type="checkbox" value=">0.5"<?= $filter->isChecked('>0.6') ? ' checked="checked"' : ''?>>
        <span class="checkbox__icon"></span>
        <span>0.5 и более</span>
    </label>
</div>