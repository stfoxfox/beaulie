<?php

use backend\helpers\ViewHelper;
use common\models\Language;
use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $provider ActiveDataProvider */


\backend\assets\custom\LanguageAsset::register($this);

$this->title = "Управление языками";
?>


<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список языков</h5>
                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr>
                                <th>код</th>
                                <th>название</th>
                                <th>активность</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var Language $item */
                            foreach($items as $item)  { ?>
                                <tr>
                                    <td><?=$item->code?></td>
                                    <td><?=$item->title?></td>

                                    <td>


                                        <a  id="item_<?=$item->id?>" href="#" class="state" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title?>" data-status="<?=$item->is_active?>"><?=($item->is_active)?"выключить":"включить"?></a>






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