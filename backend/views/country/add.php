<?php
/**
 * @var \yii\web\View $this
 * @var \backend\models\forms\CountryForm $formItem
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php $form = ActiveForm::begin(['id' => 'add-country', 'class' => 'm-t']); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Информация</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="m-t m-b">
                                 <?= $form->field($formItem, 'name')->textInput()->label('Название') ?>
                            </div>
                        </div>
                        <div class="row m-t">
                            <div class="col-md-12">
                                <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-country-button']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>