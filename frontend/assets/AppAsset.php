<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/asset_files/template';

    public $css = [
        'css/main.css',
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyAA_6Gr80xE2fpRLomSbMY1cTV7d7Ya794&v=3.exp&amp;sensor=false',
        'js/main.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
    ];
}
