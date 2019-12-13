<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FavoritesAsset extends AssetBundle
{
    public $sourcePath = '@frontend/asset_files/custom/favorites';

    public $css = [
    ];
    public $js = [
        'fav.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
