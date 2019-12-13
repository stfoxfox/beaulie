<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SearchAsset extends AssetBundle
{
    public $sourcePath = '@frontend/asset_files/custom/search';

    public $css = [
    ];
    public $js = [
        'search.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
