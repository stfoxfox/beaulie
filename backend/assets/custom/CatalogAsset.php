<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07.11.15
 * Time: 22:48
 */

namespace backend\assets\custom;

use yii\web\AssetBundle;

class CatalogAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets_files/custom/catalog';
    public $css = [
        'catalog.css'
    ];
    public $js = [
        'catalog.js'
    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\ChosenAsset',
        'common\SharedAssets\NestableAsset',
    ];

    public function init()
    {
        parent::init();

        if (YII_ENV_DEV) {
            $this->publishOptions['forceCopy'] = true;
        }
    }

}