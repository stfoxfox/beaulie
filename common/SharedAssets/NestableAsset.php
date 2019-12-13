<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 11:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class NestableAsset extends AssetBundle
{

    public $sourcePath = '@bower/nestable';


    public $css = [

    ];
    public $js = [
        'jquery.nestable.js',
    ];



}