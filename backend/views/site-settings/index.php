<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/06/2017
 * Time: 15:53
 */

use common\models\SiteSettings;
use yii\helpers\Url;


/* @var $this yii\web\View */




$asset = \backend\assets\custom\SiteSettingsAsset::register($this);
?>


<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список настроек сайта</h5>


                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Заголовок</th>
                                <th>Строковый ключ </th>
                                <th>Заначение</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var \common\models\SiteSettings $item */
                            foreach($settings as $item)  { ?>
                                <tr id="item_<?=$item->id?>">
                                    <td><?=$item->id?></td>
                                    <td><?=$item->title?></td>
                                    <td><?=$item->text_key?></td>
                                    <td>


                                        <?php if ($item->isBaseType()){
                                            ?>


                                        <a href="#" data-mode="inline"  data-type="<?=$item->getEditableType()?>" data-url="<?=Url::toRoute(['site-settings/item-edit'])?>" data-pk="<?=$item->id?>" data-placement="right" data-placeholder="Значение" data-title="<?=$item->title?>" class="editable editable-click item-settings" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->getValue()?></a>

                                        <?php
                                        } else{

                                            echo $item->getValue();
                                        }
                                        ?>

                                        </td>
                                    <td><?php

                                if ($item->type==SiteSettings::SiteSettings_TypeArray ||$item->type==SiteSettings::SiteSettings_TypeImage || $item->type==SiteSettings::SiteSettings_TypeGallery){


                                    switch ($item->type){

                                        case SiteSettings::SiteSettings_TypeArray :
                                        {
                                            $url = Url::toRoute(['index','id'=>$item->id]);
                                        }
                                        break;
                                        case SiteSettings::SiteSettings_TypeGallery :
                                        {
                                            $url = Url::toRoute(['manage-gallery','id'=>$item->id]);
                                        }
                                        break;
                                        default:{
                                            $url = Url::toRoute(['edit','id'=>$item->id]);

                                        }
                                        break;
                                    }

                                    echo  \yii\helpers\Html::a('Изменить' ,$url);


                                }
                ?>



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


