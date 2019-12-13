<?php

namespace common\models\gii;

use Yii;
use common\models\Department;
use common\models\WorkingHours;


/**
 * This is the model class for table "working_days".
 *
 * @property integer $id
 * @property integer $weekday
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $department_id
 *
 * @property Department $department
 * @property WorkingHours[] $workingHours
 */
class BaseWorkingDays extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working_days';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weekday', 'status', 'department_id'], 'required'],
            [['weekday', 'status', 'department_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weekday' => 'Weekday',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'department_id' => 'Department ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingHours()
    {
        return $this->hasMany(WorkingHours::className(), ['working_day_id' => 'id']);
    }
}
