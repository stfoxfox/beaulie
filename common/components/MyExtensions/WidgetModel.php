<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 13.08.15
 * Time: 19:31
 */
namespace common\components\MyExtensions;

use yii\base\Model;
use yii\helpers\Html;
use yii\web\UploadedFile;
use common\components\MyExtensions\MyFileSystem;
use yii\imagine\Image;

abstract class WidgetModel extends Model implements WidgetModelInterface{

    abstract public static function types();
    public $page_id;
    public $widget_name;
    public $dropDownData= [];// Have to be inited in model. Key of array is field name and array value (Array map)

    public function saveJson($widgetClass,$page_id,$page_block_id, $lang = 'ru'){
        $this->page_id = $page_id;
        $this->widget_name = basename(str_replace('\\', '/', $widgetClass));

        if($page_block_id==null){
            $page_block = new \common\models\PageBlock();
        }else{
            $page_block = \common\models\PageBlock::findOne($page_block_id);
        }        

        foreach (array_keys($this->types(),'imageInput') as $imageInputField) {
            $oldName = \Yii::$app->request->post($imageInputField.'_old');
            if( empty($oldName) || !empty(UploadedFile::getInstance($this,$imageInputField)->name)){
                $w = \Yii::$app->request->post($imageInputField.'_w');
                $h = \Yii::$app->request->post($imageInputField.'_h');
                $x = \Yii::$app->request->post($imageInputField.'_x');
                $y = \Yii::$app->request->post($imageInputField.'_y');

                $cropImage = false;
                $oldFileName = $this->uploadTo($imageInputField,$page_id,basename(str_replace('\\', '/', $widgetClass))).(empty($oldName)?'':('/'.$oldName));
                
                if($picture =UploadedFile::getInstance($this,$imageInputField)) {
                    $this->$imageInputField = uniqid()."_".md5($picture->name).".".$picture->extension;
                    $cropImage = Image::crop($picture->tempName,intval($w),intval($h),[intval($x),intval($y)]);
                }
                if ($cropImage){

                    if($oldFileName && !empty($oldName)) @unlink($oldFileName);
                    $cropImage->save(MyFileSystem::makeDirs($this->uploadTo($imageInputField,$page_id,basename(str_replace('\\', '/', $widgetClass)))));

                }
            }else{
               $this->$imageInputField = $oldName;
            }
        }

        foreach (array_keys($this->types(),'gallery') as $imageInputField) {
        if ($this->$imageInputField = UploadedFile::getInstances($this, $imageInputField)) {
            foreach ($this->$imageInputField as $image) {
                $file = new \common\models\File();
                $file->name = uniqid() . "_" . md5($image->name) . "." . $image->extension;
                $file->is_img = true;
                $file->title = null;
                $file->description = null;
                $imageFile = Image::getImagine();
                $cropImages = $imageFile->open($image->tempName);
                if($cropImages && $file->save()){
                    $cropImages->save(MyFileSystem::makeDirs($file->uploadTo("page/{$page_id}/page_block/{$this->widget_name}/gallery/{$page_block_id}/{$imageInputField}",'name')));
                    $catalog_image = new \common\models\PageBlockImage();
                    $catalog_image->file_id = $file->id;
                    $catalog_image->page_block_id = $page_block_id;
                    $catalog_image->save();
                }
            }
        }
        }

        $page_block->page_id = $page_id;
        $page_block->sort = 1;
        if ($lang) {
            $dataParam = 'data_' . $lang;
        } else {
            $dataParam = 'data';
        }

        $page_block->$dataParam = $this->toJson($widgetClass);
        if($page_block->save())
            return $page_block;
        else
            return false;
    }

    public function toJson($widgetClass){
        return \yii\helpers\Json::encode(['class_name' => $widgetClass, 'params' => $this]);
    }

    public function generateActiveValue($attribute,$model,$page_block)
    {
        $this->widget_name = basename(str_replace('\\', '/', $page_block->widgetClassName));
        $tableSchema = $model->types();
        if ($tableSchema === false || !isset($tableSchema[$attribute])) {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        }
        $column = $tableSchema[$attribute];
        if ($column === 'checkbox') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        } elseif ($column === 'textArea') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        } elseif ($column === 'textInput') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        } elseif ($column === 'link') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td><a href="'.$model->$attribute.'">'.$model->$attribute.'</a></td></tr>';
        } elseif ($column === 'hiddenInput') {
            return "";
        } elseif ($column === 'passwordInput') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        } elseif ($column === 'dropDownList') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        } elseif ($column === 'dropDownListMultiple') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.json_encode($model->$attribute).'</td></tr>';
        } elseif ($column === 'select2') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.json_encode($model->$attribute).'</td></tr>';
        } elseif ($column === 'fileInput') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        } elseif ($column === 'gallery') {
            return "<tr><td colspan='2'>".Html::a('Управление галереей', ['page/manage-gallery', 'id' => $page_block->id])."</td></tr>";
        } elseif ($column === 'imageInput') {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.(empty($model->$attribute) || !file_exists((new MyImagePublisher($model))->getFilePath(false, "{$attribute}")) ? '' : '<img id="'.$attribute./*'_'.$item->id.*/'" width="500" src="'.(new MyImagePublisher($model))->resizeInBox(512,512,false,"{$attribute}").'" alt="Picture"><a class="dell-block-field-image label label-danger pull-right" data-image-field="'.$attribute.'"><i class="fa fa-times"></i></a>').'</td></tr>';
        } elseif ($column === 'none') {
            return "";
        } else {
            return '<tr><td>'.$model->getAttributeLabel($attribute).'</td><td>'.$model->$attribute.'</td></tr>';
        }
    }

    public function generateActiveField($attribute,$model)
    {
        $tableSchema = $model->types();
        if ($tableSchema === false || !isset($tableSchema[$attribute])) {
            return "\$form->field(\$model, '$attribute')";
        }
        $column = $tableSchema[$attribute];
        if ($column === 'checkbox') {
            return "\$form->field(\$model, '$attribute')->checkbox()";
        } elseif ($column === 'textArea') {
            return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
        } elseif ($column === 'textInput') {
            return "\$form->field(\$model, '$attribute')->textInput()";
        } elseif ($column === 'link') {
            return "\$form->field(\$model, '$attribute')->textInput(['placeholder' => 'Ссылка: \"http://domain.ru/action\"'])";
        } elseif ($column === 'hiddenInput') {
            return "\$form->field(\$model, '$attribute')->hiddenInput()->label(false)";
        } elseif ($column === 'passwordInput') {
            return "\$form->field(\$model, '$attribute')->passwordInput()";
        } elseif ($column === 'dropDownList') {
            return "\$form->field(\$model, '$attribute')->dropDownList(\$model->dropDownData[\$attribute],['prompt' => 'Выбрать'])";
        } elseif ($column === 'select2') {
            return "\$form->field(\$model, '$attribute')->dropDownList(\$model->dropDownData[\$attribute],['prompt' => 'Выбрать', 'class' => 'select2', 'multiple' => true])";
        } elseif ($column === 'dropDownListMultiple') {
            return "\$form->field(\$model, '$attribute')->dropDownList(\$model->dropDownData[\$attribute],['prompt' => 'Выбрать', 'multiple' => true])";
        } elseif ($column === 'fileInput') {
            return "\$form->field(\$model, '$attribute')->fileInput()";
        } elseif ($column === 'imageInput') {
            return "'<div class=\"form-group pageBlockImageInput\" data-field-name=\"{$attribute}\">
                <label class=\"control-label\" for=\"housewidgetform-map_description\">'.\$model->getAttributeLabel(\$attribute).'</label>'.  
                \Yii\helpers\Html::hiddenInput('{$attribute}_old',\$model->\$attribute).
                \Yii\helpers\Html::hiddenInput('{$attribute}_x',0,['id'=>\$added_id.\"-n-x-{$attribute}\"]).
                \Yii\helpers\Html::hiddenInput('{$attribute}_y',0,['id'=>\$added_id.\"-n-y-{$attribute}\"]).
                \Yii\helpers\Html::hiddenInput('{$attribute}_h',0,['id'=>\$added_id.\"-n-h-{$attribute}\"]).
                \Yii\helpers\Html::hiddenInput('{$attribute}_w',0,['id'=>\$added_id.\"-n-w-{$attribute}\"]).
                \Yii\helpers\Html::activeFileInput(\$model, '$attribute',array('accept'=>'image/*','id'=>'image_n_'.\$added_id)).
                '<div class=\"m-t m-b\" style=\"display: none;\" id=\"crop_div_'.\$added_id.'\" ><img id=\"crop_img_n'.\$added_id.'\" height=\"300\" width=\"300\" src=\"\" alt=\"Picture\"></div></div>'
            ";
            //return "\$form->field(\$model, '$attribute')->fileInput()";
        } elseif ($column === 'gallery') {
            return "''";
            return "\$form->field(\$model, '{$attribute}[]')->fileInput(['multiple' => true, 'accept' => 'image/*']);";
            //return "\$form->field(\$model, '$attribute')->fileInput()";
        } elseif ($column === 'multiFileInput') {
            return "\$form->field(\$model, '$attribute')->fileInput(['multiple' => true, 'accept' => 'image/*'])";
        } elseif ($column === 'none') {
            return " null ";
        } else {
            return "\$form->field(\$model, '$attribute')";
        }
    }

    public function uploadTo($attribute,$page_id = null,$widget_name = null)
    {
        if($page_id == null) $page_id = $this->page_id;
        if($widget_name == null) $widget_name = basename(str_replace('\\', '/', $this->widget_name));

            return \Yii::getAlias('@common') . "/uploads/page/{$page_id}/page_block/{$widget_name}/{$this->$attribute}";

    }
}