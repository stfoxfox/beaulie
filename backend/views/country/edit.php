<?php
/**
 * @var \yii\web\View $this
 * @var \backend\models\forms\CountryForm $formItem
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>


<?php $form = ActiveForm::begin(['id' => 'edit-country', 'class' => 'm-t']); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Информация</h5>
                            <div class="pull-right">
                                <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['import/department','country_id'=>$item->id])?>">
                                    Импортировать магазины
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="m-t m-b">
                                <?= $form->field($formItem, 'name')->textInput()->label('Название') ?>
                            </div>
                        </div>
                        <div class="row m-t">
                            <div class="col-md-12">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>