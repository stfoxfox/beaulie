<?php
/**
 * @var $this yii\web\View
 * @var \common\models\CatalogItem $item
 */
use backend\assets\custom\ItemFormAsset;
use backend\widgets\select2\Select2Widget;
use common\components\MyExtensions\MyImagePublisher;
use common\models\CatalogCategory;
use common\models\Collection;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use common\models\Attribute;
use common\models\AttributeValue;
use backend\widgets\editable\EditableWidget;
use common\models\Brand;

?>

<?php
/* @var $form \yii\widgets\ActiveForm */
$form = ActiveForm::begin(['id' => 'add-spot', 'class' => "m-t", 'options' => ['enctype' => 'multipart/form-data']]);
?>


<div class="row">

    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Основная информация</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">




                                <?= $form->field($formItem, 'title')->textInput() ?>
                                <?= $form->field($formItem, 'description')->textarea() ?>

                                <?php // $form->field($formItem, 'types',array())->dropDownList(\common\models\SpotType::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"])  ?>

                                <?= $form->field($formItem, 'price')->textInput() ?>
                                <?= $form->field($formItem, 'old_price')->textInput() ?>
                                <?= $form->field($formItem, 'min_price')->textInput() ?>
                                <?= $form->field($formItem, 'max_price')->textInput() ?>
                                <?= $form->field($formItem, 'ext_code')->textInput() ?>


                                <?=
                                $form->field($formItem, 'categories')->widget(Select2Widget::className(), [
                                    'items' => CatalogCategory::getItemsForSelect(),
                                    'options' => [
                                        'multiple' => 'multiple',
                                        'class' => 'form-control m-r',
                                        "style" => 'width: 100%',
                                    ],
                                ]);
                                ?>



                                <?= $form->field($formItem, 'is_active')->checkbox() ?>
                                <?= $form->field($formItem, 'is_new')->checkbox() ?>
                                <?= $form->field($formItem, 'is_hit')->checkbox() ?>
                                <?= $form->field($formItem, 'is_sale')->checkbox() ?>
                                <?= $form->field($formItem, 'is_home')->checkbox() ?>
                                <?= $form->field($formItem, 'is_business')->checkbox() ?>

                                <?=
                                $form->field($formItem, 'collection_id')->widget(Select2Widget::className(), [
                                    'items' => Collection::getItemsForSelect(),
                                    'options' => [
                                        'class' => 'form-control m-r',
                                        "style" => 'width: 100%',
                                    ],
                                ]);
                                ?>

                                <?=
                                $form->field($formItem, 'brand_id')->widget(Select2Widget::className(), [
                                    'items' => Brand::getList(),
                                    'options' => [
                                        'class' => 'form-control m-r',
                                        "style" => 'width: 100%',
                                    ],
                                ]);
                                ?>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Дополнительная</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">


                                <div class="btn-group">
                                    <a href="<?=Url::toRoute(['manage-gallery','id'=>$item->id,'category_id'=>$category_id])?>" class="btn btn-white" type="button">Управление галереей</a>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">

        <div class="row">
            <div class="col-md-12">
                <?=\backend\widgets\crop\CropImageWidget::widget([

                        'form'=>$formItem,
                        'fileAttribute'=>'file_name',
                        'model'=>$item->file,
                        'related_model_path'=>\common\models\CatalogItem::tableName(),
                        'ratio'=>0
                    ]


                )?>


            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Атрибуты</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-4">
                                <?= Select2Widget::widget([
                                    'id' => 'catalog_item_attribute',
                                    'name' => 'attribute',
                                    'items' => Attribute::getList(),
                                    'clientOptions' => [
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-4 hide">
                                <?= Html::textInput('value', '', [
                                    'id' => 'catalog_item_attribute_value',
                                    'class' => 'form-control'
                                ]) ?>
                            </div>
                            <div class="col-md-4 hide">
                                <?= Select2Widget::widget([
                                    'id' => 'catalog_item_attribute_value_id',
                                    'name' => 'attribute-value',
                                    'items' => AttributeValue::getList(),
                                    'clientOptions' => [
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-outline btn-success" type="button" id="add_attribute" data-id="<?=$item->id?>">Добавить</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Значение</th>
                                        <th>Действия</th>
                                    </tr>
                                    </thead>
                                    <tbody class="sortable">
                                    <?php foreach ($item->attributeModels as $attributeModel):?>
                                        <tr>
                                            <td><?= $attributeModel->title_ru ?></td>
                                            <td>
                                                <?= EditableWidget::widget([
                                                    'name' => 'title',
                                                    'value' => $attributeModel->getValueFor($item),
                                                    'pk' => $attributeModel->id,
                                                    'url' => ['link-attribute', 'id' => $item->id],
                                                    'type' => $attributeModel->type === Attribute::TYPE_SELECT ? 'select' : 'text',
                                                    'source' => $attributeModel->type === Attribute::TYPE_SELECT ?  $attributeModel->getValuesListForEditable() : []
                                                ]) ?>
                                            </td>
                                            <td>
                                                <?=
                                                Html::a('Удалить', '#', [
                                                    'class' => 'unlink-attribute',
                                                    'data-dell-url' => Url::to(['unlink-attribute', 'id' => $item->id, 'attr_id' => $attributeModel->id]),
                                                ])
                                                ?>
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
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php $this->registerJs("
$('#catalog_item_attribute').on('select2:select', function(e) {
    var aid = e.params.data.id;
    $.ajax({
        type: 'post',
        url: '/attribute/get-values/' + aid + '.html',
        success: function (json) {
            if (json.data) {
                // show select2 hide text input
                $('#catalog_item_attribute_value_id').parent('div').removeClass('hide');
                $('#catalog_item_attribute_value').parent('div').addClass('hide');

                var newOptionsHtml = '';
                $.each(json.data, function(key, val) {
                    newOptionsHtml += '<option value=\"'+key+'\">' + value + '</option>'
                });
                $('#catalog_item_attribute_value_id').select2('destroy');
                $('#catalog_item_attribute_value_id').html(newOptionsHtml);
                $('#catalog_item_attribute_value_id').select2({});
            } else {
                // hide select2 show text input
                $('#catalog_item_attribute_value_id').parent('div').addClass('hide');
                $('#catalog_item_attribute_value').parent('div').removeClass('hide');
            }
        },
        dataType: 'json'
    });
});

$('#add_attribute').on('click', function() {
    var cid = $(this).data('id');
    var aid = $('#catalog_item_attribute').val();
    var val = $('#catalog_item_attribute_value').val();
    var avid = $('#catalog_item_attribute_value_id').val();

    $.ajax({
        type: 'post',
        url: '/catalog/link-attribute/'+cid+'.html',
        data: {
            pk: aid,
            value: val ? val : avid
        },
        success: function(json) {
            if (!json.error) {
                window.location.reload();
            }
        },
        dataType: 'json'
    });
});

$('.unlink-attribute').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: $(this).data('dell-url'),
        success: function(json) {
            if (!json.error) {
                window.location.reload();
            }
        },
        dataType: 'json'
    });
});
");