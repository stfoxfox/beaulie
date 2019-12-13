<?php

namespace common\models\gii;

use Yii;


/**
 * This is the model class for table "collection".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $sort
 * @property integer $page_id
 *
 */
class BaseCollection extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['sort', 'page_id'], 'integer'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort' => 'Sort',
            'page_id' => 'Page'
        ];
    }
}
