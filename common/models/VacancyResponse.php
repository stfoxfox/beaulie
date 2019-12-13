<?php

namespace common\models;

use Yii;
use common\models\gii\BaseVacancyResponse
;

/**
* This is the model class for table "vacancy_response".
*/
class VacancyResponse extends BaseVacancyResponse
{
    public function getStatusLabel()
    {
        $s = self::statusLabels();
        return isset($s[$this->status]) ? $s[$this->status] : 'Не определён';
    }
}
