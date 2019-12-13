<?php
/**
 * @var $this \yii\web\View
 * @var $items \common\models\Attribute[]
 */

use yii\helpers\Url;

\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
$this->title = 'Атрибуты';

?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список атрибутов</h5>
                        <div class="pull-right">
                            <a class="btn btn-outline btn-primary btn-xs" href="<?= Url::toRoute(['add']) ?>">
                                Добавить
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Заголовок</th>
                                <th>Ext key</th>
                                <th>Icon type</th>
                                <th>Единица измерения</th>
                                <th>Тип</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-url="/attribute/sort.html">
                            <?php
                            /** @var \common\models\Attribute $item */
                            foreach ($items as $item):
                                ?>
                                <tr sort-id="<?= $item->id ?>">
                                    <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
                                    <td><?= $item->title_ru ?></td>
                                    <td><?= $item->ext_key ?></td>
                                    <td><?= $item->icon_type ?></td>
                                    <td><?= $item->measure ?></td>
                                    <td><?= $item->typeLabel ?></td>
                                    <td>
                                        <a href="<?= Url::toRoute(['edit', 'id' => $item->id]) ?>">Изменить</a> |
                                        <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell'])?>" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title_ru?>">Удалить</a>
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
