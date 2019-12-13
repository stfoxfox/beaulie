<?php

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
use backend\widgets\editable\EditableWidget;

\backend\assets\custom\TagAsset::register($this);
\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5></h5>
                        <div class="pull-right">
                            <a href="<?= Url::toRoute(['add'])?>" class="btn btn-outline btn-primary btn-xs">
                                Добавить тег
                            </a>

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
                            <tbody class="sortable" data-url="/tag/sort.html">
                            <?php
                            /** @var \common\models\Tag $item */
                            foreach($items as $item)  { ?>
                                <tr sort-id="<?= $item->id ?>" id="item_<?=$item->id?>">
                                    <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
                                    <td><?= $item->title_ru?></td>
                                    <td>
                                        <a href="<?=Url::toRoute(['edit','id'=>$item->id])?>">Изменить</a> |
                                        <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell'])?>" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title_ru?>">Удалить</a>
                                    </td>
                                </tr>
                            <?php  } ?>

                            </tbody>
                        </table>

                        <?= \yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
