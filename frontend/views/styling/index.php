<?php
use common\components\MyExtensions\MyFilePublisher;
use common\components\MyExtensions\MyHelper;
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;

$this->title = "Укладка и уход: ".$category->title_ru;
?>
<main class="page page_inner">
    <div class="page-layout page-layout_size_2">
        <div class="banner banner_thin">
            <a class="banner__back" href="<?= Url::toRoute(['news/index'])?>"></a>
            <div class="banner__title">Укладка и уход</div>
        </div>
        <div class="breadcrumbs">
            <div class="breadcrumbs__main">
                <a class="breadcrumbs__item" href="<?= Url::toRoute(['news/index'])?>">Новости и информация</a>/<span class="breadcrumbs__item">Укладка и уход</span>
            </div>
        </div>
        <div class="catalog catalog_news js-widget" onclick="return {catalog: {}}">
            <div class="catalog__aside">
                <div class="content-menu">
                    <select class="select">
                    <?php foreach ($categories as $category): ?>
                        <option><?=$category->title?></option>
                    <?php endforeach?>
                    </select>
                    
                    <ul>
                    <?php foreach ($categories as $category): ?>
                        <li><a class="<?= $id == $category->id ? 'content-menu__item content-menu__item_active' : 'content-menu__item'?>" href="<?= Url::toRoute(['styling/view', 'id' => $category->id])?>"><?= $category->title ?> </a></li>
                    <?php endforeach?>
                    </ul>
                </div>
            </div>
            <div class="catalog__main">
                <div class="catalog__inner">
                    <div class="catalog__wrap">
					<?php foreach ($styling as $st): ?>
                      	<div class="catalog__item">
                        	<div class="catalog__item-wrap">
								<a class="product-card js-widget" href="#" onclick="return {productCard: {id: <?=$st->id?>}}">
                            		<div class="product-card__image">
										<img src="<?=(new MyImagePublisher($st->image))->resizeInBox(1600, 1200, false, 'file_name', 'styling')?>">
									</div>
								    <div class="product-card__subtitle"><?=$st->title_ru?></div>
								</a>
                          		<div class="product-info product-info_style_1 js-widget" onclick="return { productInfo: { id: <?=$st->id?>} }" data-id="<?=$st->id?>">
                            		<div class="product-info__close close"></div>
                            		<div class="product-info__wrap product-info__wrap_no-flex">
                              			<div class="product-info__subtitle"><?=$st->subtitle_ru?></div>
                                        <p class="text text_size_2"><?= MyHelper::formatTextToHTML($st->text)?></p>
                                        <?php if($st->file_id !== NULL):?>                                        
                                            <div class="links-row">
                                                <a download class="link link_gray" href="<?= (new MyFilePublisher($st->file))->publishFile('file_name', 'styling')?>">Скачать</a>
                                            </div>
                                        <?php endif ?>
                            		</div>
                          		</div>
                        	</div>
					  	</div>
					<?php endforeach?>
                    </div>
                    <!-- <div class="catalog__bottom"><a class="btn btn_black btn_mail">
                        <div class="btn__icon btn__icon_fav">
                            <svg>
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fav"></use>
                            </svg>
                        </div>
                        <span>ОТПРАВИТЬ НА E-MAIL</span></a><a class="btn btn_black btn_no-min-width btn_download">
                            <svg>
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-download"></use>
                            </svg></a>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</main>