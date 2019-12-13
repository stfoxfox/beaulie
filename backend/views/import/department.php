<?php
/**
 * @var $model \backend\models\forms\DepartmentImportForm
 * @var $this \yii\web\View
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Импорт магазинов';

$form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]);
echo $form->errorSummary($model);
echo $form->field($model, 'file')->fileInput();
echo Html::submitButton('Импортировать');

$form->end();