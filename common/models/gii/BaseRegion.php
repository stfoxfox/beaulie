<?php

namespace common\models\gii;

use common\models\Country;
use Yii;
use common\models\Department;


/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property boolean $is_default
 * @property integer $country_id
 * @property boolean $popup
 *
 * @property Department[] $departments
 * @property Country $country
 */
class BaseRegion extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['is_default', 'popup'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_default' => 'Is Default',
            'country_id' => 'Country'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
