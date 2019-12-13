<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Vacancy;
/**
* This is the model class for Vacancy form.
*/
class VacancyForm extends Model
{
    public $title_ru;
    public $title_en;
    public $title_ua;
    public $title_kz;
    public $title_by;
    public $description_ru;
    public $description_en;
    public $description_ua;
    public $description_kz;
    public $description_by;
    public $requirements_ru;
    public $requirements_en;
    public $requirements_ua;
    public $requirements_kz;
    public $requirements_by;
    public $conditions_ru;
    public $conditions_en;
    public $conditions_ua;
    public $conditions_kz;
    public $conditions_by;
    public $department_ru;
    public $department_en;
    public $department_ua;
    public $department_kz;
    public $department_by;
    public $sort;
    public $is_active;

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

    public function attributeLabels()
    {
        return [
            'is_active' => 'Активна'
        ];
    }

    /**
     * @param Vacancy $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->title_en = $item->title_en;
        $this->title_ua = $item->title_ua;
        $this->title_kz = $item->title_kz;
        $this->title_by = $item->title_by;
        $this->description_ru = $item->description_ru;
        $this->description_en = $item->description_en;
        $this->description_ua = $item->description_ua;
        $this->description_kz = $item->description_kz;
        $this->description_by = $item->description_by;
        $this->requirements_ru = $item->requirements_ru;
        $this->requirements_en = $item->requirements_en;
        $this->requirements_ua = $item->requirements_ua;
        $this->requirements_kz = $item->requirements_kz;
        $this->requirements_by = $item->requirements_by;
        $this->conditions_ru = $item->conditions_ru;
        $this->conditions_en = $item->conditions_en;
        $this->conditions_ua = $item->conditions_ua;
        $this->conditions_kz = $item->conditions_kz;
        $this->conditions_by = $item->conditions_by;
        $this->department_ru = $item->department_ru;
        $this->department_en = $item->department_en;
        $this->department_ua = $item->department_ua;
        $this->department_kz = $item->department_kz;
        $this->department_by = $item->department_by;
        $this->sort = $item->sort;
        $this->is_active = $item->is_active;
    }

    /**
     * @inheritdoc
     * @var Vacancy $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->description_ru = $this->description_ru;
        $item->description_en = $this->description_en;
        $item->description_ua = $this->description_ua;
        $item->description_kz = $this->description_kz;
        $item->description_by = $this->description_by;
        $item->requirements_ru = $this->requirements_ru;
        $item->requirements_en = $this->requirements_en;
        $item->requirements_ua = $this->requirements_ua;
        $item->requirements_kz = $this->requirements_kz;
        $item->requirements_by = $this->requirements_by;
        $item->conditions_ru = $this->conditions_ru;
        $item->conditions_en = $this->conditions_en;
        $item->conditions_ua = $this->conditions_ua;
        $item->conditions_kz = $this->conditions_kz;
        $item->conditions_by = $this->conditions_by;
        $item->department_ru = $this->department_ru;
        $item->department_en = $this->department_en;
        $item->department_ua = $this->department_ua;
        $item->department_kz = $this->department_kz;
        $item->department_by = $this->department_by;
        $item->sort = $this->sort;
        $item->is_active = $this->is_active;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new Vacancy();

        $item->title_ru = $this->title_ru;
        $item->title_en = $this->title_en;
        $item->title_ua = $this->title_ua;
        $item->title_kz = $this->title_kz;
        $item->title_by = $this->title_by;
        $item->description_ru = $this->description_ru;
        $item->description_en = $this->description_en;
        $item->description_ua = $this->description_ua;
        $item->description_kz = $this->description_kz;
        $item->description_by = $this->description_by;
        $item->requirements_ru = $this->requirements_ru;
        $item->requirements_en = $this->requirements_en;
        $item->requirements_ua = $this->requirements_ua;
        $item->requirements_kz = $this->requirements_kz;
        $item->requirements_by = $this->requirements_by;
        $item->conditions_ru = $this->conditions_ru;
        $item->conditions_en = $this->conditions_en;
        $item->conditions_ua = $this->conditions_ua;
        $item->conditions_kz = $this->conditions_kz;
        $item->conditions_by = $this->conditions_by;
        $item->department_ru = $this->department_ru;
        $item->department_en = $this->department_en;
        $item->department_ua = $this->department_ua;
        $item->department_kz = $this->department_kz;
        $item->department_by = $this->department_by;
        $item->sort = $this->sort;
        $item->is_active = $this->is_active;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
