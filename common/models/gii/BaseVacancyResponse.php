<?php

namespace common\models\gii;

use common\models\File;
use Yii;
use common\models\Vacancy;


/**
 * This is the model class for table "vacancy_response".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property string $info
 * @property string $department
 * @property integer $vacancy_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $file_id
 *
 * @property Vacancy $vacancy
 * @property File $file
 */
class BaseVacancyResponse extends \common\components\MyExtensions\MyActiveRecord
{
    const STATUS_NEW = 10;
    const STATUS_READ = 20;
    const STATUS_PROCESSED = 30;

    /**
     * @return array
     */
    public static function statusLabels()
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'Новый'),
            self::STATUS_READ => Yii::t('app', 'Прочитан'),
            self::STATUS_PROCESSED => Yii::t('app', 'Обработан'),
        ];
    }

    /**
     * @return array
     */
    public static function statusLabelsForEditable()
    {
        $result = [];
        foreach (self::statusLabels() as $status => $label) {
            $result[] = ['value' => $status, 'text' => $label];
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacancy_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'phone', 'email', 'department', 'vacancy_id'], 'required'],
            [['vacancy_id', 'status', 'file_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'surname', 'phone', 'email', 'info', 'department'], 'string', 'max' => 255],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'email' => 'Email',
            'info' => 'Info',
            'file_id' => 'File',
            'department' => 'Department',
            'vacancy_id' => 'Vacancy ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::className(), ['id' => 'vacancy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'vacancy_id']);
    }
}
