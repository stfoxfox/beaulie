<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 0:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class EditDepartmentAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets_files/custom/edit_department';


    public $css = [

        'edit_department.css'



    ];
    public $js = [
        'edit_department.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\MomentAsset',
        'common\SharedAssets\XEditableAsset',

    ];


}