<?php

namespace backend\assets\custom;

use yii\web\AssetBundle;

class TagAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets_files/custom/tag';

    public $css = [
    ];
    
    public $js = [
        'tag.js'
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