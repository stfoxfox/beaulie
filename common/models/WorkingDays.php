<?php

namespace common\models;

use Yii;
use common\models\gii\BaseWorkingDays
;

/**
* This is the model class for table "working_days".
*/
class WorkingDays extends BaseWorkingDays
{



    const DAY_MON=1;
    const DAY_TUE=2;
    const DAY_WEN=3;
    const DAY_TRU=4;
    const DAY_FRI=5;
    const DAY_SAT=6;
    const DAY_SUN=7;

    const STATUS_NOT_SET = 0;
    const STATUS_24_OPEN = 1;
    const STATUS_CLOSED = 2;
    const STATUS_HAS_HOURS = 3;


    public function getDepartmentHours(){

        if($this->id ){

            if ($deliveryHours=$this->getWorkingHours()->one()){


                return [
                    'hours'=>
                        [
                            'start'=>substr($deliveryHours->open_time, 0, -3),
                            'stop'=>substr($deliveryHours->close_time, 0, -3),

                        ]
                ];

            }

        }


        return [
            'hours'=>
                [
                    'start'=>'',
                    'stop'=>'',

                ]
        ];
    }
}
