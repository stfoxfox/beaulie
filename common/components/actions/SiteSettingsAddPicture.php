<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 05/07/2017
 * Time: 01:03
 */

namespace common\components\actions;

use common\components\MyExtensions\MyImagePublisher;
use yii\base\Action;

class SiteSettingsAddPicture extends BlockAddPicture
{
    public $_form;
    public $_model;
    public $related_model_path='site_settings';
}