<?php
/**
 * @var \common\models\CatalogCategory $model
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
                    <a href="<?= Url::to(['add-group', 'category_id' => $model->id]) ?>"><i class="fa fa-plus"></i> Добавить группу</a>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody class="sortable"  data-url="/filter/sort-group.html">
                    <?php foreach ($model->getFilterGroups()->orderBy('sort')->all() as $item): ?>
                        <tr sort-id="<?= $item->id ?>">
                            <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
                            <td><?= $item->title_ru ?></td>
                            <td>
                                <?= Html::a('Редактировать', ['edit-group', 'id' => $item->id]) ?> |
                                <?= Html::a('Фильтры', ['view-group', 'id' => $item->id]) ?> |
                                <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell-group'])?>" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title_ru?>">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>