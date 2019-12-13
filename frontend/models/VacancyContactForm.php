<?php

namespace frontend\models;

use common\components\MyExtensions\MyFileSystem;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\UploadedFile;
use common\models\SiteSettings;

/**
 * ContactForm is the model behind the contact form.
 */
class VacancyContactForm extends Model
{
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $info;
    public $file_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'phone', 'email'], 'required'],
            // name, email, subject and body are required
            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['pdf', 'doc', 'docx', 'rtf', 'tiff', 'htm', 'html'],'maxFiles'=>1, 'maxSize' => (1024 * 5)],
            [['name', 'surname'], 'string', 'max' => 80],
            [['info'], 'string'],
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
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $email = SiteSettings::get('careerEmail');
        if ($email && $this->validate()) {
            $body = $this->name . ' ' . $this->surname . "\n" .
                    $this->phone . "\n" .
                    $this->email . "\n\n" .
                    $this->info;

            $mail = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(['no-reply@bigfloor.pro' => 'Beaulieu career'])
                ->setSubject(Yii::t('app', 'Отклик со страницы вакансий'))
                ->setTextBody($body);

            if ($file = UploadedFile::getInstance($this, 'file_name')) {

                $filePath = Yii::getAlias('@common') . '/uploads/attachments/' . md5($file->name) . uniqid() . '.' . $file->extension;
                $path = MyFileSystem::makeDirs($filePath);
                if ($file->saveAs($path)) {
                    $mail->attach($path);
                }
            }

            return $mail->send();
        } else {
            return false;
        }
    }
}
