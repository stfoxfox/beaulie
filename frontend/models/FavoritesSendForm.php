<?php

namespace frontend\models;

use common\components\MyExtensions\MyFileSystem;
use yii\base\Model;

class FavoritesSendForm extends Model
{
    public $category_id;
    public $name;
    public $email;
    public $phone;
    public $message;

    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['name', 'email', 'phone', 'message'], 'string'],
            [['email'], 'email'],
        ];
    }

    public function send()
    {
        if ($this->validate()) {
            $csv = Favorites::generateCSV($this->category_id);
            $tempPath = \Yii::getAlias('@common') . '/uploads/send/beaulieu.favorites.' . date('Y-m-d') . '.csv';
            $path = MyFileSystem::makeDirs($tempPath);
            file_put_contents($path, $csv);

            $mail = \Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom(['no-reply@bigfloor.pro' => 'Beaulieu favorites'])
                ->setSubject(\Yii::t('app', 'Избранное'))
                ->setTextBody($this->message)
                ->attach($tempPath);


            return $mail->send(); //&& @unlink($path);
        } else {
            return false;
        }

    }
}