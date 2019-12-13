<?php

namespace common\models\gii;

use Yii;


/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $title
 *
 */
class BaseTag extends \common\components\MyExtensions\MyActiveRecord
{
    public $created_at;
    public $updated_at;
    /**
     * @inheritdoc
     */
    public static function tabletitle()
    {
        return 'tag';
    }

        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by',], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'title',
        ];
    }
}
