<?php

namespace frontend\models;

use common\components\MyExtensions\MyFileSystem;
use common\models\Department;
use common\models\SiteSettings;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $department;
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['name'], 'string', 'max' => 80],
            [['message'], 'string'],
            [['department'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * Sends an email to the preset email address using the information collected by this model.
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        if ($this->department) {
            $department = Department::findOne($this->department);
        }

        $email = SiteSettings::get('contactEmail');
        if ($email) {
            $subject = Yii::t('app', 'Контакты: обратная связь') . (!empty($department) ? '. ' . ucfirst($department->title) : '');
            return Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(['no-reply@bigfloor.pro' => 'no-reply@bigfloor.pro'])
                ->setSubject($subject)
                ->setTextBody($this->message)
                ->send();
        }

        return false;
    }
}
