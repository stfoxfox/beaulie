<?php

namespace common\models\gii;

use Yii;
use common\models\Region;
use common\models\WorkingDays;


/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $title
 * @property string $address
 * @property integer $region_id
 * @property string $phone
 * @property string $phone_2
 * @property string $site_url
 * @property double $lat
 * @property double $lng
 * @property integer $sort
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Region $region
 * @property WorkingDays[] $workingDays
 */
class BaseDepartment extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['region_id', 'sort'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at', 'lat', 'lng'], 'safe'],
            [['title', 'address', 'phone', 'phone_2', 'site_url'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'address' => 'Address',
            'region_id' => 'Region ID',
            'phone' => 'Phone',
            'phone_2' => 'Phone 2',
            'site_url' => 'Site Url',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'sort' => 'Sort',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkingDays()
    {
        return $this->hasMany(WorkingDays::className(), ['department_id' => 'id']);
    }

    public function getWorkingHours()
    {
        return '8:00 - 23:00';
    }

    public function getWorkingHoursByDays()
    {
        $result = [];
        $mon_fri = [1, 2, 3, 4, 5];
        foreach ($this->workingDays as $day) {
            if (in_array($day->weekday, $mon_fri)) {
                $result[] = 'пн-пт ' .$day->getDepartmentHours()['hours']['start'] . ' - ' . $day->getDepartmentHours()['hours']['stop'];
                break;
            }
            if ($day->weekday === 6) {
                $result[] = 'сб ' .$day->getDepartmentHours()['hours']['start'] . ' - ' . $day->getDepartmentHours()['hours']['stop'];
            }
            if ($day->weekday === 7) {
                $result[] = 'вс ' .$day->getDepartmentHours()['hours']['start'] . ' - ' . $day->getDepartmentHours()['hours']['stop'];
            }
        }

        return  implode(', ', $result);
    }
}
