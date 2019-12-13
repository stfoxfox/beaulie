<?php
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;

$this->title = 'Новости';
?>
<main class="page page_inner news">
    <div class="page-layout page-layout_size_2">
        <div class="banner banner_thin banner_blue">
            <a class="banner__back" href="<?= Url::toRoute(['news/index'])?>"></a>
            <div class="banner__title">Новости</div>
        </div>
        
        <div class="breadcrumbs">
            <div class="breadcrumbs__main">
                <a class="breadcrumbs__item" href="<?= Url::toRoute(['news/index'])?>">Новости и информация</a>/
                <span class="breadcrumbs__item">Новости</span>
            </div>
        </div>
              
        <div class="news__inner filter js-widget" onclick="return {contentFilter: { liveSearch: true, dataUrl: 'filter.html' } }">
            <form class="filter__form">
                <div class="filter__opener">
                    <span>Фильтр<span class="filter__clear">(Сбросить)</span></span>
                    <span class="filter__icon"></span>
                </div>
                <div class="filter__wrap">
                    <div class="filter__inner filter__inner_size_1">
                        <div class="filter__col">
                            <div class="filter__title">по категориям</div>
                            <div class="filter__list">
                                <select class="select" data-placeholder="Тип сортировки" name="type">
                                    <option></option>
                                <?php foreach($categories as $category): ?>
                                    <option><?= $category->title_ru ?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter__col">
                            <div class="filter__title">По тэгу</div>
                            <div class="filter__list">
                            <?php foreach($tags as $tag): ?>
                                <label class="text-tag">#<?= $tag->title_ru ?>
                                    <input type="checkbox" name="tag" value="<?= $tag->id ?>">
                                </label>
                            <?php endforeach ?>
                            </div>
                        </div>
                        <div class="filter__col">
                            <div class="filter__title">По периоду</div>
                            <div class="filter__list">
                                <div class="filter__row">
                                    <div class="filter__inner-col">
                                        <select class="select" data-placeholder="Месяц" name="month">
                                            <option></option>
                                            <option value=1>Январь</option>
                                            <option value=2>Февраль</option>
                                            <option value=3>Март</option>
                                            <option value=4>Апрель</option>
                                            <option value=5>Май</option>
                                            <option value=6>Июнь</option>
                                            <option value=7>Июль</option>
                                            <option value=8>Август</option>
                                            <option value=9>Сентябрь</option>
                                            <option value=10>Октябрь</option>
                                            <option value=11>Ноябрь</option>
                                            <option value=12>Декабрь</option>
                                        </select>
                                    </div>
                                    <div class="filter__inner-col">
                                        <select class="select" data-placeholder="Год" name="year">
                                            <option></option>
                                            <option>2017</option>
                                            <option>2018</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="news__details">
                <div class="news__loader filter__loader"></div>
                <div class="news__error filter__error">К сожалению ничего не найдено, попробуйте задать другие параметры</div>
                <div class="content-list news__content filter__content js-widget" onclick="return {contentList: {}}">
                <?php foreach($newsList as $news): ?>
                    <div class="content-list__row">
                        <div class="content-list__item">
                            <span class="content-list__close"></span>
                            <div class="content-list__image">
                                <img src="<?=(new MyImagePublisher($news->file))->resizeInBox(140, 140, false, 'file_name', 'news')?>">
                            </div>
                            <div class="content-list__info">
                                <div class="content-list__wrap">
                                    <div class="content-list__header">
                                    <?php foreach($news->catalogCategories as $category): ?>
                                        <a class="content-list__link" href="#"><?= $category->title_ru ?></a>
                                    <?php endforeach ?>
                                    <?php foreach($news->tags as $tag): ?>
                                        <span class="content-list__tag">#<?= $tag->title_ru ?></span>
                                    <?php endforeach ?>
                                    </div>
                                    <div class="content-list__title"><?= $news->title_ru?></div>
                                </div>
                                <div class="content-list__date"><?= MyHelper::formatDate($news->created_at) ?></div>
                            </div>
                        </div>
                        <div class="content-list__additional"><?= $this->render('@frontend/views/common/_pageBlocks', ['page' => $news->page])?></div>
                    </div>
                <?php endforeach ?>
                </div>
                <div class="pagination filter__pagination" style="">
                <?php if($pages > 1):?>
                    <div class="pagination__prev">
                        <a class="btn" href="#" data-id="prev">Предыдущая</a>
                    </div>
                    <div class="pagination__center">
                    <?php $currentPage = 1; ?>
                    <?php while($currentPage <= $pages):?>
                        <a class="<?= $currentPage == 1 ? "pagination__item pagination__item_active" : "pagination__item" ?>" data-id="<?= $currentPage?>"><?= $currentPage?></a>
                        <?php $currentPage++; ?>
                    <?php endwhile ?>
                    </div>
                    <div class="pagination__next">
                        <a class="btn" href="#" data-id="next">Следующая</a>
                    </div>
                <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</main>