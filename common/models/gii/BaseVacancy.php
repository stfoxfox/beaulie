<?php

namespace common\models\gii;

use Yii;


/**
 * This is the model class for table "vacancy".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property string $description_ru
 * @property string $description_en
 * @property string $description_ua
 * @property string $description_kz
 * @property string $description_by
 * @property string $requirements_ru
 * @property string $requirements_en
 * @property string $requirements_ua
 * @property string $requirements_kz
 * @property string $requirements_by
 * @property string $conditions_ru
 * @property string $conditions_en
 * @property string $conditions_ua
 * @property string $conditions_kz
 * @property string $conditions_by
 * @property integer $sort
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $department_ru
 * @property string $department_en
 * @property string $department_ua
 * @property string $department_kz
 * @property string $department_by
 */
class BaseVacancy extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacancy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['description_ru', 'description_en', 'description_ua', 'description_kz', 'description_by', 'requirements_ru', 'requirements_en', 'requirements_ua', 'requirements_kz', 'requirements_by', 'conditions_ru', 'conditions_en', 'conditions_ua', 'conditions_kz', 'conditions_by', 'department_ru', 'department_en', 'department_ua', 'department_kz', 'department_by'], 'string'],
            [['sort'], 'integer'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Title Ru',
            'title_en' => 'Title En',
            'title_ua' => 'Title Ua',
            'title_kz' => 'Title Kz',
            'title_by' => 'Title By',
            'description_ru' => 'Description Ru',
            'description_en' => 'Description En',
            'description_ua' => 'Description Ua',
            'description_kz' => 'Description Kz',
            'description_by' => 'Description By',
            'requirements_ru' => 'Requirements Ru',
            'requirements_en' => 'Requirements En',
            'requirements_ua' => 'Requirements Ua',
            'requirements_kz' => 'Requirements Kz',
            'requirements_by' => 'Requirements By',
            'conditions_ru' => 'Conditions Ru',
            'conditions_en' => 'Conditions En',
            'conditions_ua' => 'Conditions Ua',
            'conditions_kz' => 'Conditions Kz',
            'conditions_by' => 'Conditions By',
            'sort' => 'Sort',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
