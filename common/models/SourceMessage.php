<?php

namespace common\models;

use Yii;
use common\models\gii\BaseSourceMessage
;

/**
* This is the model class for table "source_message".
*/
class SourceMessage extends BaseSourceMessage
{

    public function getMessageForLang($lang){

        return $this->hasMany(Message::className(), ['id' => 'id'])->andWhere(['language'=>$lang]);
    }

}
