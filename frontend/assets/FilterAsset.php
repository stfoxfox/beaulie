<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FilterAsset extends AssetBundle
{
    public $sourcePath = '@frontend/asset_files/custom/filter';

    public $js = [
        'js/filter.js'
    ];
    
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
