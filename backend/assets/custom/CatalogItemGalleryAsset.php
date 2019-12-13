<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 30/06/2017
 * Time: 22:24
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class CatalogItemGalleryAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/catalog_item_gallery';




    public $css = [

        //   'blog.css'



    ];
    public $js = [
        'catalog_item_gallery.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\CroperAsset',
        'common\SharedAssets\JqueryFormAsset',
        'common\SharedAssets\LightboxAsset',



    ];

}