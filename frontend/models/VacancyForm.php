<?php

namespace frontend\models;

use common\models\File;
use common\models\VacancyResponse;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Vacancy;

class VacancyForm extends Model
{
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $vacancy_id;
    public $department;

    public $info;
    public $file_name;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'phone', 'email', 'department', 'vacancy_id'], 'required'],
            [['info'], 'string'],
            [['email'], 'email'],
            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['pdf', 'doc', 'docx', 'rtf', 'tiff', 'htm', 'html'],'maxFiles'=>1, 'maxSize' => (1024 * 5)],
            [['name', 'surname'], 'string', 'max' => 80],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }

    /**
     * @return bool
     */
    public function submit()
    {
        if (!$this->validate())
            return false;

        $model = new VacancyResponse();
        $model->name = $this->name;
        $model->surname = $this->surname;
        $model->phone = $this->phone;
        $model->email = $this->email;
        $model->info = $this->info;
        $model->vacancy_id = $this->vacancy_id;
        $model->department = $this->department;

        if ($file = UploadedFile::getInstance($this, 'file_name')) {
            $model->file_id = File::saveFile($file, VacancyResponse::tableName());
        }

        if (!$model->save()) {
            $this->addErrors($model->getErrors());
            return false;
        } else
            return true;
    }
}