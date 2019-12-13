<?php
/**
 * @var $this \yii\web\View
 * @var $items \common\models\Vacancy[]
 */

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
use yii\helpers\Html;

\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список брендов</h5>
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
                                <th>Изображение</th>
                                <th>Название</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-url="/brand/sort.html">
                            <?php
                            /** @var \common\models\Brand $item */
                            foreach ($items as $item):
                                ?>
                                <tr sort-id="<?= $item->id ?>">
                                    <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
                                    <td><?= Html::img($item->file ? (new MyImagePublisher($item->file))->resizeInBox(100,100,false,'file_name', 'brand') : '#', ['alt' => $item->title_ru]) ?></td>
                                    <td><?= $item->title_ru ?></td>
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
