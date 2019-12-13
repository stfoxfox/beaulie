<?php
/**
 * @var $this \yii\web\View
 * @var $items \common\models\Attribute[]
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "Управление укладкой и уходом категории: $category->title_ru";
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
                            <a class="btn btn-outline btn-primary btn-xs" href="<?= Url::toRoute(['add-styling', 'id' => $category->id]) ?>">
                                Добавить
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Подзаголовок</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-url="/catalog/sort-category-styling.html">
                            <?php
                            /** @var \common\models\Styling $item */
                            foreach ($items as $item):
                                ?>
                                <tr sort-id="<?= $item->id ?>">
                                    <td><?= $item->title_ru ?></td>
                                    <td><?= $item->subtitle_ru ?></td>
                                    <td>
                                        <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell-category-styling'])?>" data-item-id="<?= $item->id ?>" data-item-name="<?=$item->title_ru?>">Удалить</a> | 
                                        <a class="edit-item" href="<?= Url::toRoute(['edit-item-styling', 'id' => $item->id]) ?>">Изменить</a>
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
