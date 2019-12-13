<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\Attribute $item
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Language;
use common\models\Attribute;
use backend\widgets\editable\EditableWidget;

$languages = Language::getActive();

\common\SharedAssets\DeleteAsset::register($this);
\common\SharedAssets\SortAsset::register($this);
?>


<?php $form = ActiveForm::begin(['id' => 'add-attribute', 'class'=>"m-t"]); ?>

<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Основная информация</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($formItem, 'ext_key')->textInput() ?>
                                <?= $form->field($formItem, 'icon_type')->dropDownList(Attribute::ICONS, ['prompt' => 'Выбрать']) ?>
                                <?php if ($formItem->type === Attribute::TYPE_NUMBER): ?>
                                    <?= $form->field($formItem, 'measure')->textInput(['class' => 'form-control']) ?>
                                <?php endif; ?>
                                <?= $form->field($formItem, 'type')->dropDownList(Attribute::typeLabels()) ?>

                            </div>
                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">
                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Информация</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="m-t m-b">
                            <ul class="nav nav-tabs">
                                <?php foreach ($languages as $language): ?>
                                    <li<?= Language::isRussian($language) ? ' class="active"' : '' ?>><a data-toggle="tab" href="#<?=$language?>"><?= $language ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <br />
                            <div class="tab-content">
                                <?php foreach ($languages as $language): ?>
                                    <div id="<?= $language ?>" class="tab-pane fade in<?= Language::isRussian($language) ? ' active' : '' ?>">
                                        <?= $form->field($formItem, 'title_' . $language)->textInput()->label('Заголовок') ?>
                                        <?= $form->field($formItem, 'standard_' . $language)->textInput()->label('Норма ГОСТа') ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($formItem->type === Attribute::TYPE_SELECT): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Значения атрибута</h5>
                        <div class="pull-right">
                            <a class="btn btn-outline btn-primary btn-xs" href="<?= Url::toRoute(['add-value', 'id' => $item->id]) ?>">
                                Добавить
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="m-t m-b">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Заголовок</th>
                                    <th>Ext key</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody class="sortable" data-url="/attribute/sort-values.html">
                                <?php foreach ($item->attributeValues as $value): ?>
                                    <tr sort-id="<?= $value->id ?>">
                                        <td><span class="btn btn-info"><i class="fa fa-bars"></i></span></td>
                                        <td><?=
                                            EditableWidget::widget([
                                                'name' => 'title_ru',
                                                'value' => $value->title_ru,
                                                'pk' => $value->id,
                                                'url' => ['edit-value'],
                                            ])
                                            ?>
                                        </td>
                                        <td><?=
                                            EditableWidget::widget([
                                                'name' => 'ext_key',
                                                'value' => $value->ext_key,
                                                'pk' => $value->id,
                                                'url' => ['edit-value'],
                                            ])
                                            ?>
                                        </td>
                                        <td>
                                            <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell-value'])?>" data-item-id="<?=$value->id?>" data-item-name="<?=$value->title_ru?>">Удалить</a>
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
        <?php endif; ?>
    </div>
</div>
<?php ActiveForm::end(); ?>



