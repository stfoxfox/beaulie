<?php

namespace common\models\gii;

use Yii;
use common\models\WorkingDays;


/**
 * This is the model class for table "working_hours".
 *
 * @property integer $id
 * @property string $open_time
 * @property string $close_time
 * @property string $created_at
 * @property string $updated_at
 * @property integer $working_day_id
 *
 * @property WorkingDays $workingDay
 */
class BaseWorkingHours extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working_hours';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['open_time', 'close_time', 'created_at', 'updated_at'], 'safe'],
            [['working_day_id'], 'integer'],
            [['working_day_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkingDays::className(), 'targetAttribute' => ['working_day_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'open_time' => 'Open Time',
            'close_time' => 'Close Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'working_day_id' => 'Working Day ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingDay()
    {
        return $this->hasOne(WorkingDays::className(), ['id' => 'working_day_id']);
    }
}
