<?php
/**
 * @var $this \yii\web\View
 * @var $items \common\models\Vacancy[]
 */

use yii\helpers\Url;

\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
$this->title = 'Вакансии';

?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список вакансий</h5>
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
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-url="/vacancy/sort.html">
                            <?php
                            /** @var \common\models\Vacancy $item */
                            foreach ($items as $item):
                                ?>
                                <tr sort-id="<?= $item->id ?>">
                                    <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
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
