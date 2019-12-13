<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\VacancyResponse;
/**
* This is the model class for VacancyResponse form.
*/
class VacancyResponseForm extends Model
{
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $info;
    public $file_name;
    public $department;
    public $vacancy_id;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'phone', 'email', 'department', 'vacancy_id'], 'required'],
            [['vacancy_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'surname', 'phone', 'email', 'info', 'file_name', 'department'], 'string', 'max' => 255],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }

    /**
     * @param VacancyResponse $item
     */
    public function loadFromItem($item)
    {
        $this->name = $item->name;
        $this->surname = $item->surname;
        $this->phone = $item->phone;
        $this->email = $item->email;
        $this->info = $item->info;
        $this->file_name = $item->file_name;
        $this->department = $item->department;
        $this->vacancy_id = $item->vacancy_id;
        $this->status = $item->status;
    }

    /**
     * @inheritdoc
     * @var VacancyResponse $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->name = $this->name;
        $item->surname = $this->surname;
        $item->phone = $this->phone;
        $item->email = $this->email;
        $item->info = $this->info;
        $item->file_name = $this->file_name;
        $item->department = $this->department;
        $item->vacancy_id = $this->vacancy_id;
        $item->status = $this->status;
    
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

        $item = new VacancyResponse();

        $item->name = $this->name;
        $item->surname = $this->surname;
        $item->phone = $this->phone;
        $item->email = $this->email;
        $item->info = $this->info;
        $item->file_name = $this->file_name;
        $item->department = $this->department;
        $item->vacancy_id = $this->vacancy_id;
        $item->status = $this->status;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
