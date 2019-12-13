<?php
/* @var $category \common\models\CatalogCategory */
/* @var $groups \common\models\CatalogCategoryFilterGroup[] */
/* @var $is_home boolean */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="popup popup_filters filters-popup" id="filters-popup">
    <form class="filter" action="<?= Url::toRoute(['catalog/index']) ?>">
        <?= Html::hiddenInput('id', $category->id) ?>
        <?= Html::hiddenInput('is_home', $is_home) ?>
        <div class="nano">
            <div class="nano-content">
                <div class="filters-popup__inner">
                    <?php



                    foreach ($groups as $filterGroup) :?>

                    <?php /** @var \common\models\CatalogCategoryFilter $one_any_filter */
                        // у разных фильтров - разные классы на дивах!
                        $one_any_filter = $filterGroup->getMainCatalogCategoryFilters()->one();

                        if ($one_any_filter && $one_any_filter->type == \common\models\CatalogCategoryFilter::TYPE_COLLECTION) {
                            echo Html::beginTag('div', ['class' => 'filters-popup__row filter-selector js-widget', 'onclick' => 'return {filterSelector: {}}']);

                        } else {
                            echo Html::beginTag('div', ['class' => 'filters-popup__row filter__inner']);
                        }
                    ?>

                        <?php foreach ($filterGroup->getMainCatalogCategoryFilters()->orderBy('sort')->all() as $filter) :?>
                            <?php /** @var \common\models\CatalogCategoryFilter $filter */?>

                            <?php if ($filter->type == \common\models\CatalogCategoryFilter::TYPE_COLLECTION) :?>
                                <div class="filter__title"><?= $filter->title ?></div>
                                <?=$this->render('_filterCollectionList', ['filter' => $filter])?>

                            <?php else :?>
                                <div class="filter__col">
                                    <div class="filter__title"><?= $filter->title ?></div>
                                    <?=$this->render('_filterList', ['filter' => $filter])?>
                                </div>

                            <?php endif?>
                        <?php endforeach?>

                        <?=$this->render('_boolFilterList', [
                            'filters' => $filterGroup->getBooleanCatalogCategoryFilters()->orderBy('sort')->all()
                        ])?>

                    <?=Html::endTag('div')?>
                    <?php endforeach?>
                </div>
            </div>
        </div>
        <div class="filters-popup__bottom">
            <button class="btn btn_red" type="submit"><?= mb_strtoupper(Yii::t('app.mainFilter', 'Применить')) ?></button>
            <button class="btn" type="reset"><?= mb_strtoupper(Yii::t('app.mainFilter', 'Сбросить')) ?></button>
        </div>
    </form>
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

})
", \yii\web\View::POS_END);