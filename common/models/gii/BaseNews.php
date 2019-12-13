<?php

namespace common\models\gii;

use Yii;


/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $page_id
 * @property integer $file_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property File $file
 */
class BaseNews extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['file_id', 'page_id'], 'integer'],
            [['text_ru', 'text_en', 'text_ua', 'text_kz', 'text_by', 'title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'text' => 'Text',
            'file_id' => 'File ID',
            'page_id' => 'Page ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
