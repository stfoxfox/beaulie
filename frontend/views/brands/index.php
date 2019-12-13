<?php
/* @var $this \yii\web\View */
/* @var $items \common\models\Brand[] */
/* @var $page \common\models\Page */
/* @var $pages \yii\data\Pagination */

use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use frontend\widgets\Pager;

$this->title = $page->title;
?>
<main class="page page_inner">
    <div class="page-layout page-layout_size_2">
        <div class="banner banner_brown">
            <div class="banner__main" style="background: <?= $page->banner_color ?>">
                <div class="banner__title"><?= $this->title ?></div>
                <div class="banner__text"><?= $page->banner_text ?></div>
            </div>
            <div class="banner__image" style="<?= $page->bannerFile ? 'background-image' : 'background' ?>: <?= $page->bannerFile ? 'url(' . (new MyImagePublisher($page->bannerFile))->resizeInBox(450, 300, false, 'file_name', 'page') . ')': $page->banner_color ?>;"></div>
        </div>
        <div class="brands-page js-widget" onclick="return {brandsPage: {}}">
            <div class="brands-page__header">
<!--                <div class="brands-page__selector">-->
<!--                    <select class="select" data-placeholder="Тип сортировки">-->
<!--                        <option></option>-->
<!--                        <option>По цене</option>-->
<!--                    </select>-->
<!--                </div>-->
                <div class="brands-page__counter"><?= $n = count($items) ?> <?= Yii::t('app.brands', '{n,plural,=0{нет брендов} =1{бренд} =2{бренда} =3{бренда} =4{бренда} other{брендов}}', ['n' => $n]) ?></div>
            </div>
            <div class="brands-page__inner">
                <?php if (!empty($items)): ?>
                    <?php foreach($items as $item): ?>
                        <div class="brands-page__item brand-item js-widget"">
                            <div class="brand-item__aside">
                                <div class="brand-item__logo">
                                    <div class="brand-item__icon"><img src="<?= $item->file ? (new MyImagePublisher($item->file))->resizeInBox(300, 300, false, 'file_name', 'brand') : '' ?>"></div>
                                    <div class="brand-item__title-wrap">
                                        <div class="brand-item__title"><?= $item->title ?></div>
                                        <div class="brand-item__type">Паркет</div>
                                    </div>
                                </div>
                                <div class="brand-item__image"><img src="<?= $item->brandFile ? (new MyImagePublisher($item->brandFile))->resizeInBox(300, 300, false, 'file_name', 'brand') : '' ?>"></div>
                                <div class="brand-item__title-line">
                                    <div class="brand-item__title"><?= $item->title ?></div>
                                    <div class="brand-item__type">Паркет</div>
                                </div>
                            </div>
                            <div class="brand-item__info">
                                <div class="brand-item__info-wrap">
                                    <div class="brand-item__text"><?= $item->about ?></div><a class="link link_red" href="#">www.sensecompany.com</a>
                                </div>
                                <div class="brand-item__buttons">
                                    <?php $cats = $item->getTags();  if (!empty($cats)): ?>
                                        <?php foreach ($cats as $cat): ?>
                                            <a class="btn brand-item__btn" href="<?= Url::toRoute(['catalog/index', 'id' => $cat->id]) ?>"><?= $cat->title ?></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <a class="btn brand-item__btn brand-item__btn_back" href="#" onclick="$.magnificPopup.close()">В каталог</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?= Pager::widget([
                'linkOptions' => ['class' => 'btn'],
                'options' => [
                    'class' => 'brands-page__pagination',
                ],
                'pagination' => $pages,
            ]); ?>
        </div>
    </div>
</main>