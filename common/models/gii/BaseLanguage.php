<?php

namespace common\models\gii;

use Yii;


/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class BaseLanguage extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 2],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
