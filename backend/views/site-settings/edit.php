<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/06/2017
 * Time: 23:08
 */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Редактирование настроки";
?>


<?php $form = ActiveForm::begin(['id' => 'add-author', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">


        <div class="col-md-6 col-md-offset-3" >

            <div class="row">




                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                           <?=\backend\widgets\crop\CropImageWidget::widget([
                               'form'=>$formItem,
                               'fileAttribute'=>'file_name',
                               'related_model_path'=>\common\models\SiteSettings::tableName(),
                               'model'=>$item->file,
                               'ratio'=>0
                           ])?>
                            <hr>
                            <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>

                </div>





            </div>
        </div>





    </div>

<?php ActiveForm::end(); ?>