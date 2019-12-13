<?php
/**
 * @var $model \backend\models\forms\DropboxImportForm
 * @var $this \yii\web\View
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Импорт изображений';

$form = ActiveForm::begin(['method' => 'post']);
echo $form->errorSummary($model);
echo $form->field($model, 'api_key')->textInput();
echo $form->field($model, 'api_secret')->textInput();
echo $form->field($model, 'access_token')->textInput();
echo Html::submitButton('Импортировать');

$form->end();