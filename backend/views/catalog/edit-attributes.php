<?php
/**
 * @var $this \yii\web\View
 * @var $items \common\models\Attribute[]
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Редактирование атрибутов';
\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список атрибутов</h5>
                        <div class="pull-right">
                            <a class="btn btn-outline btn-primary btn-xs" href="<?= Url::toRoute(['add-attribute', 'id' => $category->id]) ?>">
                                Добавить
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>В коллекции</th>
                                <th>В тех. характеристиках</th>
                                <th>В товаре</th>
                                <th>Иконка</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-url="/catalog/sort-category-attributes.html">
                            <?php
                            /** @var \common\models\CatalogCategoryAttribute $item */
                            foreach ($items as $item):
                                ?>
                                <tr sort-id="<?= $item->id ?>">
                                    <td><?= $item->attributeModel->title_ru ?></td>
                                    <td><?= $item->show_in_collection ? 'Да' : 'Нет' ?></td>
                                    <td><?= $item->show_in_list ? 'Да' : 'Нет' ?></td>
                                    <td><?= $item->show_in_catalog_item ? 'Да' : 'Нет' ?></td>
                                    <td><?= $item->show_collection_icon ? 'Да' : 'Нет' ?></td>
                                    <td>
                                        <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell-category-attribute'])?>" data-item-id="<?= $item->id ?>" data-item-name="<?=$item->attributeModel->title_ru?>">Удалить</a>
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
