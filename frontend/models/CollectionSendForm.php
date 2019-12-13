<?php

namespace frontend\models;

use common\components\MyExtensions\MyFileSystem;
use common\models\Collection;
use yii\base\InvalidParamException;
use yii\base\Model;

class CollectionSendForm extends Model
{
    public $model;

    public function init()
    {
        if (!$this->model && !$this->model instanceof Collection) {
            throw new InvalidParamException('Model must be instance of collection');
        }
    }

    public $name;
    public $email;
    public $phone;
    public $message;

    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'message'], 'string'],
            [['email'], 'email'],
        ];
    }

    public function send()
    {
        if ($this->validate()) {
            $csv = Favorites::generateCSV();
            $tempPath = \Yii::getAlias('@common') . '/send/beaulieu.favorites.' . date('Y-m-d') . '.csv';
            $path = MyFileSystem::makeDirs($tempPath);
            file_put_contents($path, $csv);

            $mail = \Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom(['no-reply@bigfloor.pro' => 'Beaulieu collection'])
                ->setSubject(\Yii::t('app', $this->model->title))
                ->setTextBody($this->message)
                ->attach($tempPath);


            return $mail->send() && @unlink($path);
        } else {
            return false;
        }

    }
}