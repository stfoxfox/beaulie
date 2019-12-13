<?php

/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 07.08.15
 * Time: 18:17
 */
use backend\assets\custom\CatalogAsset;
use common\components\MyExtensions\MyImagePublisher;
use common\models\CatalogCategory;
use common\models\CatalogItem;
use yii\helpers\Html;
use yii\helpers\Url;

\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
//$asset = CatalogAsset::register($this);

/**
 * @var CatalogCategory $category
 * @var CatalogCategory[] $roots
 * @var $this yii\web\View
 */


CatalogAsset::register($this);

$cat_id = 0;

?>

<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="file-manager">

                    <div class="hr-line-dashed"></div>
                    <h5>Категории</h5>

                    <div class="dd" id="nestable">
                        <ol class="dd-list" id="folder_list">
                            <?php foreach ($roots as $root): ?>
                                <?= $this->render('root_view',[
                                    'root' => $root,
                                    'category' => $category
                                ]); ?>
                            <?php endforeach; ?>
                        </ol>
                    </div>

                    <ul class="folder-list" style="padding: 0">
                        <li><a href="#"  id="createCategory" data-url="<?= Url::to(['add-category',]) ?>"><i class="fa fa-plus"></i> Добавить категорию</a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Категория: <?= $category->title_ru ?></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="pull-right btn-group">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?= Url::toRoute(['add-item', 'id' => $category->id]) ?>">
                                Добавить элемент
                            </a>
                            <a class="btn  btn-outline btn-xs btn-success" href="<?= Url::toRoute(['edit-category', 'id' => $category->id]) ?>">Изменить категорию</a>
                            <a class="btn  btn-outline btn-xs btn-success" href="<?= Url::toRoute(['import/xlsx', 'category_id' => $category->id]) ?>">Импорт данных</a>
                            <a class="btn  btn-outline btn-xs btn-success" href="<?= Url::toRoute(['import/dropbox']) ?>">Импорт изображений</a>
                            <a class="btn  btn-outline btn-xs btn-danger" href="<?= Url::toRoute(['delete-all']) ?>">Удалить все товары</a>
                        </div>
                        <br />
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                                <tr><th>#</th>
                                    <th>Фото</th>
                                    <th>Название</th>
                                    <th>Цена</th>

                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-url="<?=Url::toRoute(['items-sort','id'=>$category->id])?>">

                                <?php
                                /* @var $menuItem CatalogItem */
                                $items = $category->getCatalogItems()->leftJoin('catalog_item_category','catalog_item_category.catalog_item_id = catalog_item.id')
                               ->orderBy('catalog_item_category.sort')
                                //->with(['recipesCategories'])
                                ->all();
                                ?>
                                <?php foreach ($items as $menuItem): ?>
                                    <tr id="item_<?= $menuItem->id ?>" sort-id="<?= $menuItem->id ?>" data-cat="<?= $cat_id ?>">
                                        <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                        <td><?php if ($menuItem->file_id) { ?><img width="50" height="50" src="<?= (new MyImagePublisher($menuItem->file))->MyThumbnail(100, 100,'file_name',CatalogItem::tableName()) ?>"> <?php } else echo "-"; ?></td>
                                        <td><?= $menuItem->title ?></td>
                                        <td><a href="#" id="item-price" data-type="text" data-url="<?= Url::toRoute(['catalog/item-edit-price']) ?>" data-pk="<?= $menuItem->id ?>" data-placement="right" data-placeholder="price" data-title="Item price" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?= $menuItem->price ?></a></td>

                                        <td>
                                            <?= Html::a('Изменить', ['edit-item', 'id' => $menuItem->id,'category_id'=>$category->id]) ?>
                                            | 
                                            <?= Html::a('Удалить', '#', ['class' => 'dell-item',
                                                        'data-item-id' => $menuItem->id,
                                                    'data-item-name' => $menuItem->title,
                                                    'data-dell-id'>="item_",
                                                    'data-dell-url' => Url::to(['item-dell'])]

                                            ) ?>
                                            <?php if (count($menuItem->catalogCategories) > 1): ?>
                                                | 
                                                <?=
                                                Html::a('Удалить из категории', '#', [
                                                    'class' => 'dell-item',
                                                    'data-item-id' => $menuItem->id,
                                                    'data-item-name' => $menuItem->title,
                                                    'data-dell-id'>="item_",
                                                    'data-dell-url' => Url::to(['item-dell-from-category', 'categoryId' => $category->id]),
                                                ])
                                                ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal inmodal fade" id="edit-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

        </div>
    </div>
</div>

