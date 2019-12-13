<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/07/2017
 * Time: 15:21
 * @var Language[] $languages
 */

use common\models\Language;
use common\widgets\Nav;
use yii\helpers\Url;
use yii\widgets\LinkPager;

\common\SharedAssets\EditableAsset::register($this);
$languages = Language::find()->where(['is_active'=>1])->all();

$this->title="Управление переводами";
?>

<?php
$items = [];

foreach ($languages as $language) {
    $items[] = [
        'label' => $language->title,
        'url' => Url::current(['lang' => $language->code]),
        'active' => $language->code == $lang,
    ];
}

echo Nav::widget([
    'options' => [
        'class' => 'nav nav-tabs',
        'role' => 'tablist',
        'style' => 'margin-bottom: 40px;',
    ],
    'encodeLabels' => false,
    'items' => $items,
]);
?>



<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список  переводов</h5>
                        <?=\yii\helpers\Html::beginForm(Url::toRoute(['index','lang'=>$lang]),'GET')?>
                           <div class="row"><div class="col-md-5 pull-right"><div class="input-group">


                                       <input value="<?=Yii::$app->request->get('search_key')?>"  name="search_key" type="text" class="form-control"> <span class="input-group-btn">

                                           <?=\yii\bootstrap\Html::submitButton('искать',['class'=>'btn btn-primary'])?>
                                           </span></div>



                               </div> </div>
                        <?=\yii\helpers\Html::endForm()?>


                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr>

                                <th>Категория</th>
                                <th>Ключ </th>
                                <th>Значение</th>
                            </tr>
                            </thead>
                            <tbody class="sortable">

                            <?php
                            /** @var \common\models\SourceMessage $item */

                            foreach($messages as $item)  { ?>
                                <tr >

                                    <td><?=$item->category?></td>
                                    <td><?=$item->message?></td>
                                    <td><a href="#" data-name="<?=$lang?>"   data-type="textarea" data-url="<?=Url::toRoute(['item-save'])?>" data-pk="<?=$item->id?>" data-placement="left" data-placeholder="Значение" data-title="Значение" class="editable editable-click item-settings" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->getMessageForLang($lang)->one()->translation?></a></td>



                                </tr>
                            <?php  } ?>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="10" class="footable-visible">

                                    <?php

                                    echo LinkPager::widget([
                                        'pagination' => $pages,
                                        'options'=>['class' => 'pagination pull-right']
                                    ]);

                                    ?>
                                </td>
                            </tr>
                            </tfoot>
                        </table>




                    </div>
                </div>


            </div>
        </div>



    </div>
</div>

