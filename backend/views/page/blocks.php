<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/07/2017
 * Time: 01:26
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

\backend\assets\custom\PageBlocksAsset::register($this);
?>

<div class="row">
    <div class="col-md-12" >
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins" >
                    <div class="ibox-title">
                        <h5>Контент</h5>
                        <?=Html::hiddenInput('block_sort',null,['id'=>"block_sort"])?>
                        <div class="pull-right btn-group">
                            <button data-toggle="dropdown" class="btn btn-sm btn-success m-t-n-xs dropdown-toggle" aria-expanded="false">Добавить блок <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <?php foreach (\common\models\PageBlock::BLOCKS as $key=> $type){?>
                                    <li><a href="#" class="add-block" data-item-id="<?=$item->id?>" data-block-type="<?=$key?>"><?php $class = $type['widgetClass']; echo $class::getBlockName() ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row" id="sortable-view">
                    <div id="blocks-list" class="col-lg-12 ui-sortable">
                        <?php
                        /**
                         *
                         * @var \common\models\PageBlock $block
                         * @var \common\models\Page $item
                         */
                        foreach ($item->getPageBlocks()->all() as $block) {
                            //echo Yii::$app->controller->renderPartial($block->getBlockTemplateForBackend(),['item'=>$block]);
                            $widgetClass = $block->widgetClassName;
                            $params = $block->dataParams;
                            /**
                             * @var \common\components\MyExtensions\MyWidgetInterface $block_widget
                             */
                            $block_widget = new $widgetClass(['page_id' => $item->id, 'params' => $params]);
                            if($block_widget){
                                echo $block_widget->backendView($block);
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Контент</h5>
                        <div class="pull-right btn-group">
                            <button data-toggle="dropdown" class="btn btn-sm btn-success m-t-n-xs dropdown-toggle" aria-expanded="false">Добавить блок <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <?php foreach (\common\models\PageBlock::BLOCKS as $key=> $type){
                                    ?>
                                    <li><a href="#" class="add-block" data-item-id="<?=$item->id?>" data-block-type="<?=$key?>"><?php $class = $type['widgetClass']; echo $class !== '' ? $class::getBlockName() : 'какой то блок'; ?></a></li>
                                    <?php
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

