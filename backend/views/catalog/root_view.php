<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 26/07/2017
 * Time: 19:34
 * @var  \common\models\CatalogCategory $root
 */
use yii\helpers\Url;

?>

<li class="dd-item" data-id="<?=$root->id?>" id="cat_id_<?=$root->id?>">
    <a data-cat="<?= $root->id ?>" data-cat_name="<?= $root->title_ru ?>" class="label label-info pull-right dell-item"  data-dell-url="<?=Url::toRoute(['dell'])?>" data-dell-id="cat_id_" data-item-id="<?=$root->id?>" data-item-name="<?=$root->title_ru?>">x</a>
    <div class="dd-handle"><span class="dd-h "><i class="fa fa-list"></i></span>  <a <?php if ($root->id == $category->id) echo "class='text-bold'"; ?> id="#a-cat-<?= $root->id ?>" href="<?= Url::toRoute(['view', 'id' => $root->id]) ?>"><?=$root->title_ru?></a>
    </div>


    <?php if (count($root->catalogCategories)>0) { ?>
        <ol class="dd-list">
            <?php foreach ($root->getCatalogCategories()->orderBy('sort')->all() as $item) {



                echo $this->render('root_view',['root'=>$item,'category'=>$category]);


            } ?>
        </ol>

    <?php } ?>


</li>


