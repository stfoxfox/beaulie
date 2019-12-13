<?php

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;

\common\SharedAssets\DeleteAsset::register($this)
?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5></h5>
                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['add'])?>">
                                Добавить новость
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Заголовок</th>
                                <th>Управление блоками</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            <?php
                            /** @var \common\models\News $item */
                            foreach($items as $item)  { ?>
                                <tr id="item_<?=$item->id?>">
                                    <td><?=$item->title_ru?></td>
                                    <td> <a href="<?=Url::toRoute(['page/blocks', 'id' => $item->page_id])?>"?>Редактировать</a> </td>
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
