<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19/07/2017
 * Time: 15:37
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class LanguageAsset extends AssetBundle
{


    public $sourcePath = '@backend/assets_files/custom/language';




    public $css = [


    ];
    public $js = [
        'language.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];

}