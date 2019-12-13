<?php

namespace common\models;

use Yii;
use common\models\gii\BaseVacancy
;

/**
* This is the model class for table "vacancy".
*/
class Vacancy extends BaseVacancy
{
    public function getByLines($attr)
    {
        $lines = explode(PHP_EOL, $this->$attr);
        array_walk($lines, function (&$item) {
            $item = ucfirst($item);
        });
        return $lines;
    }
}
