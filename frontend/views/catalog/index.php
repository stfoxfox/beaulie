<?php
/**
 * @var $model \frontend\models\CatalogItemSearch
 * @var $category \common\models\CatalogCategory
 * @var $filters \common\models\CatalogCategoryFilterGroup[]
 * @var $data array ['collection' => '', 'items' => []]
 * @var $is_home boolean
 */
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;

$this->title = $category->title;
?>

<main class="page page_inner">
    <div class="page-layout page-layout_size_2">
        <div class="banner" style="background: <?= $is_home ? $category->home_color : $category->business_color ?>;">
            <div class="banner__main">
                <div class="banner__title"><?= $this->title ?></div>
                <div class="banner__text"><?= $is_home ? $category->description : $category->business_description ?></div>
                <div class="banner__links">
                    <a class="banner__link<?= $is_home ? ' banner__link_active' : '' ?>" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => true])?>">Я покупаю для себя</a>
                    <a class="banner__link<?= !$is_home ? ' banner__link_active' : '' ?>" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id]) ?>">Я покупаю для бизнеса</a>
                </div>
            </div>
            <div class="banner__image" style="background-image: url(<?= $is_home ? ($category->file  ? (new MyImagePublisher($category->file))->resizeInBox(450, 300, false, 'file_name', 'catalog_category') : '') : ($category->businessFile ? (new MyImagePublisher($category->businessFile))->resizeInBox(300, 300, false, 'file_name', 'catalog_category') : '') ?>);"></div>
        </div>

        <?php if(count($category->getQuickFilterGroups($is_home)) > 0): ?>
            <?= $this->render('_filter', [
                'groups' => $category->getQuickFilterGroups($is_home), 
                'additionalGroups' => $category->getMainFilterGroups($is_home),
                'category' => $category, 'is_home' => $is_home]) 
            ?>
        <?php endif ?>

        <div class="breadcrumbs">
            <div class="breadcrumbs__main">
                <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => $is_home])?>"><?= $category->title ?></a>/
                <?php if ($is_home): ?>
                    <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => true])?>"><?= Yii::t('app.catalog.breadcrumbs', 'Для себя')?></a>/
                <?php else: ?>
                    <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id])?>"><?= Yii::t('app.catalog.breadcrumbs', 'Для бизнеса')?></a>/
                <?php endif; ?>
                <a class="breadcrumbs__item" href="<?= Url::toRoute(['catalog/index', 'id' => $category->id, 'is_home' => $is_home])?>"><?= Yii::t('app.catalog.breadcrumbs', 'Все коллекции')?></a>
            </div>
            <span class="breadcrumbs__item"><?= Yii::t('app.catalog', 'Количество коллекций')?>: <span id="collections-count"><?= count($data) ?></span></span>
        </div>

        <div id="main-catalog">
            <?= $this->render('_catalog', [
                'category' => $category,
                'model' => $model,
                'data' => $data,
                'is_home' => $is_home
            ]); ?>
        </div>


    </div>

    <?php //$this->render('_filterPopup', [
        //'groups' => $category->getMainFilterGroups($is_home),
        //'category' => $category,
        //'is_home' => $is_home
    //]) ?>
</main>