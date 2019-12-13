<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 0:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class DepartmentFormAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets_files/custom/department_form';


    public $css = [

        'department_form.css'



    ];
    public $js = [
        'department_form.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',

    ];


}