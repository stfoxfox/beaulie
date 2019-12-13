<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var $filter \common\models\CatalogCategoryFilter
 */

$chunks = null;
$values = $filter->getValuesByAlphabet();
if (count($values) > 3) {
    $chunks = array_chunk($values, 3, true);
}

$groups = [];
if ($chunks) {
    foreach ($chunks as $chunk) {
        $keys = array_keys($chunk);

        $key = $keys[0];
        if (count($keys) > 1)
            $key = "{$keys[0]}-{$keys[count($keys) - 1]}";

        $groups [$key] = $chunk;
    }
}
?>

<div class="filter__col filter-selector js-widget-inited" onclick="return {filterSelector: {}}">
    <div class="filter__col filter__col_full">
        <div class="filter__title"><?= $filter->title ?></div>
        <div class="filter__list">
            <div class="filter-selector__main-row">
                <?php foreach ($groups as $letter => $group) :?>
                    <?=Html::button($letter, ['class' => 'btn filter-selector__btn', 'data-id' => $letter])?>
                <?php endforeach?>

                <button class="btn filter-selector__btn" type="button" data-id="all">Показать все</button>
            </div>

            <?php foreach ($groups as $letter => $group) :?>
                <?=Html::beginTag('div', ['class' => 'filter-selector__row', 'data-id' => $letter])?>
                <?=Html::beginTag('div', ['class' => 'filter__inner filter__inner_flex-start', 'data-id' => $letter])?>
                <div class="filter__list-col">
                <?php foreach ($group as $litera => $filters) :?>                  
                    <?php foreach ($filters as $id => $value) :?>
                        <div class="filter__item">
                            <label class="checkbox">
                                <input name="<?=$filter->getInputName()?>" class="checkbox__input" type="checkbox" value="<?=$id?>" <?=$filter->isChecked($value) ? 'checked="checked"' : ''?>>
                                <span class="checkbox__icon"></span>
                                <?=Html::tag('span', $value)?>
                            </label>
                        </div>
                    <?php endforeach?>
                <?php endforeach?>
                </div>
                <?=Html::endTag('div')?>
                <?=Html::endTag('div')?>
            <?php endforeach?>
        </div>
    </div>  
</div>
<?php $this->registerJs("
$('button[type=reset]').on('click', function(e) {
  e.preventDefault();
  $('#filters-popup form input[type=\"checkbox\"]').each(function(k, e) {
    $(e).prop('checked', false)
  });
});
$('#filters-popup form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var quickForm = $('#quick-filter');
    var id = form.find('input[name=id]').val();
    var isHome = form.find('input[name=is_home]').val();
    var qString  = 'id=' + id + '&is_home=' + isHome + '&';
    $.each(form.find('input[type=checkbox]'), function(key, obj) {
      if ($(obj).is(':checked')) {
        qString += $(obj).attr('name') + '=' + $(obj).val() + '&';
      }
    });

    var quickFilterString = '';
    $.each(quickForm.find('input[type=checkbox]'), function(key, obj) {
      if ($(obj).is(':checked')) {
        quickFilterString += $(obj).attr('name') + '=' + $(obj).val() + '&';
      }
    });

    var query = quickFilterString + '&' + qString;

    var url = form.attr('action') + '?' + query;
    window.location = url;

});
$('.filter-selector__btn').on('click', function(e){
    e.preventDefault();
    id = $(this).data('id');
    $(this).parent().find('.filter-selector__btn').removeClass('btn_active');
    $(this).addClass('btn_active');
    if(id == 'all'){
        $(this).parent().parent().find('.filter-selector__row').addClass('filter-selector__row_active');
    }else{
        $(this).parent().parent().find('.filter-selector__row').removeClass('filter-selector__row_active');
        $(this).parent().parent().find('.filter-selector__row[data-id=' + id + ']').addClass('filter-selector__row_active');
    }
    
})
", \yii\web\View::POS_END);

