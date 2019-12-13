<?php

namespace common\models;

use Yii;
use common\models\gii\BasePage
;

/**
* This is the model class for table "page".
*/
class Page extends BasePage
{
    public function getBannerFile()
    {
        return $this->hasOne(File::className(), ['id' => 'banner_file_id']);
    }
}
