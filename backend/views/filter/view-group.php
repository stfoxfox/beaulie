<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\CatalogCategoryFilterGroup
 */
use yii\helpers\Html;
use yii\helpers\Url;
use common\SharedAssets\DeleteAsset;
use common\SharedAssets\SortAsset;

DeleteAsset::register($this);
SortAsset::register($this);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список</h5>
                <div class="pull-right">
                    <a href="<?= Url::to(['add', 'id' => $model->catalog_category_id, 'group_id' => $model->id]) ?>"><i class="fa fa-plus"></i> Добавить фильтр</a>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Фильтр</th>
                        <th>Тип</th>
                        <th>Тип отображения</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="sortable" data-url="/filter/sort.html">
                    <?php foreach ($model->getCatalogCategoryFilters()->orderBy('sort')->all() as $item): ?>
                        <tr sort-id="<?= $item->id ?>">
                            <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
                            <td><?= $item->title ?></td>
                            <td><?= $item->typeLabel ?></td>
                            <td><?= $item->viewTypeLabel ?></td>
                            <td>
                                <?= Html::a('Редактировать', ['edit', 'id' => $item->id]) ?> |
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

