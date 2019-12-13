<?php
/**
 * @var $model \backend\models\forms\XlsxImportForm
 * @var $this \yii\web\View
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Импорт товаров';

$form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]);
echo $form->errorSummary($model);
echo $form->field($model, 'file')->fileInput();
echo $form->field($model, 'import_items')->checkbox();
echo $form->field($model, 'import_attributes')->checkbox();
echo $form->field($model, 'import_attribute_values')->checkbox();
echo $form->field($model, 'delete_not_updated')->checkbox();
echo Html::submitButton('Импортировать');

$form->end();
?>

<br />

<?php
if ($model->importedItemsCount) {
    echo "<p>Количество добавленных товаров: {$model->importedItemsCount}</p>";
}
if ($model->importedBrandsCount) {
    echo "<p>Количество добавленных брендов: {$model->importedBrandsCount}</p>";
}
if ($model->importedCollectionsCount) {
    echo "<p>Количество добавленных колекций: {$model->importedCollectionsCount}</p>";
}
if ($model->importedAttributesCount) {
    echo "<p>Количество добавленных атрибутов: {$model->importedAttributesCount}</p>";
}
if ($model->updatedItemsCount) {
    echo "<p>Количество обновлённых товаров: {$model->updatedItemsCount}</p>";
}
if ($model->importedAttributeValuesCount) {
    echo "<p>Количество добавленных значений селективных атрибутов: {$model->importedAttributeValuesCount}</p>";
}
if ($model->deletedItemsCount) {
    echo "<p>Количество удалённых товаров: {$model->deletedItemsCount}</p>";
}
