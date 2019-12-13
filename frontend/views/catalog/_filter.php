<?php
/* @var $category \common\models\CatalogCategory */
/* @var $groups \common\models\CatalogCategoryFilterGroup[] */
/* @var $is_home boolean */

use frontend\assets\FilterAsset;
use yii\helpers\Url;
use yii\helpers\Html;

FilterAsset::register($this);

?>
<form id="quick-filter" action="<?= Url::toRoute(['catalog/index']) ?>">
    <?= Html::hiddenInput('id', $category->id) ?>
    <?= Html::hiddenInput('is_home', $is_home) ?>
    <div class="filter js-widget" onclick="return {contentFilter: {}}">
        <div class="filter__opener">
            <span>Фильтр<span class="filter__clear">(Сбросить)</span></span>
            <span class="filter__icon"></span>
        </div>
        <div class="filter__wrap">
        <?php if(count($additionalGroups) > 0) :?>
            <a class="filter__additional-link link link_gray" >Дополнительный фильтр</a>
        <?php endif ?>
            <div class="filter__inner">
                <?php foreach ($groups as $group): ?>
                    <?php foreach ($group->getMainCatalogCategoryFilters()->orderBy('sort')->all() as $filter): ?>
                    <div class="filter__col">
                        <div class="filter__title"><?= $filter->title ?></div>
                        <?= $this->render('_filterList', ['filter' => $filter]) ?>
                    </div>
                    <?php endforeach; ?>
                    <?= $this->render('_boolFilterList', [
                        'filters' => $group->getBooleanCatalogCategoryFilters()->orderBy('sort')->all()
                    ]); ?>
                <?php endforeach; ?>
            </div>
            <div class = "filter__additional">
            <?php foreach ($additionalGroups as $filterGroup) :?>
                <?php $filters = $filterGroup->getMainCatalogCategoryFilters()->orderBy('sort')->all(); ?>
                <?php $isCollection = 0;?>
                <?php foreach($filters as $f) :?>
                <?php if($f->type == \common\models\CatalogCategoryFilter::TYPE_COLLECTION): ?>
                <?php $isCollection = 1;?>
                <?php break ?>
                <?php endif ?>
                <?php endforeach ?>
                <?php if($isCollection):?>
                        <div class = "filter__inner filter__inner_full-tablet">
                <?php else:?>
                        <div class = "filter__inner filter__inner_flex-start">
                <?php endif ?>             
                <?php foreach ($filterGroup->getMainCatalogCategoryFilters()->orderBy('sort')->all() as $filter) :?>
                    <?php /** @var \common\models\CatalogCategoryFilter $filter */?>
                    <?php if ($filter->type == \common\models\CatalogCategoryFilter::TYPE_COLLECTION) :?>
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
                </div>
                <?php endforeach?>
                <div class="filter-footer">
                    <button class="btn btn_red" type="submit"><?= mb_strtoupper(Yii::t('app.mainFilter', 'Применить')) ?></button>
                    <button class="btn" type="reset"><?= mb_strtoupper(Yii::t('app.mainFilter', 'Сбросить')) ?></button>
                </div>
            </div>
        </div>
    </div>
</form>