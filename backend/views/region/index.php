<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 29/11/2016
 * Time: 00:28
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;

\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);

?>


<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="file-manager">
                    <?php



                    ?>

                    <div class="hr-line-dashed"></div>
                    <h5>Регионы</h5>


                    <ul class="sortable folder-list" style="padding: 0" data-url="<?=Url::toRoute(['region-sort'])?>">

                        <?php


                        foreach($regions as $region){
                            ?>
                            <li  id="item_<?= $region->id ?>" sort-id="<?= $region->id ?>" <?php if($region->id == $selectedRegion->id) echo "class='text-bold'"; ?>><a id="#a-cat-<?=$region->id?>" href="<?=Url::toRoute(['view','id'=>$region->id])?>"><i class="fa fa-folder"></i> <?=$region->title?>

                                    <?= Html::tag('span','x', ['class' => 'dell-item label label-info pull-right',
                                            'data-item-id' => $region->id,
                                            'data-item-name' => $region->title,
                                            'data-dell-id'>="item_",
                                            'data-dell-url' => Url::to(['region-dell'])]

                                    ) ?>

                                </a></li>


                        <?php }  ?>



                    </ul>

                    <ul class="folder-list" style="padding: 0">
                        <li><a href="<?=Url::toRoute(['region-add'])?>" id="createCategory"><i class="fa fa-plus"></i> Добавить регион</a></li>
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
                        <h5>Регион: <?=$selectedRegion->title?></h5>
                        <div class="pull-right btn-group">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['region/add-department','id'=>$selectedRegion->id])?>">
                                Добавить магазин
                            </a>

                            <a type="button" class="btn  btn-outline btn-xs btn-success" href="<?=Url::toRoute(['edit-region','id'=>$selectedRegion->id])?>">Изменить регион</a>
                            <a  class="btn btn-outline btn-danger btn-xs" href="<?=Url::toRoute(['region/delete-all-shops'])?>">
                                Удалить все магазины
                            </a>
                        </div>

                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Адрес</th>
                                <th>Телефон</th>
                                <th>Активен</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-url="<?=Url::toRoute(['department-sort'])?>">

                            <?php
                            /** @var \common\models\Department $item */
                            foreach($selectedRegion->departments as $item)  { ?>
                                <tr id="department_<?=$item->id?>" sort-id="<?=$item->id?>" data-cat="<?=$selectedRegion->id?>">
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                     <td><?=$item->address?></td>
                                    <td><?=$item->phone?></td>
                                    <td><?=$item->is_active?></td>

                                    <td><a href="<?=Url::toRoute(['edit-department','id'=>$item->id])?>" class="edit-catalog-item" >изменить</a> |

                                        <?= Html::a('Удалить',null, ['class' => 'dell-item',
                                                'data-item-id' => $item->id,
                                                'data-item-name' => $item->title,
                                                'data-dell-id'=>"department_",
                                                'data-dell-url' => Url::to(['department-dell'])]

                                        ) ?>

                                    </td>

                                </tr>
                            <?php  } ?>

                            </tbody>
                        </table>




                    </div>
                </div>


            </div>
        </div>



    </div>
</div>
