<?php

namespace common\models\gii;

use Yii;
use common\models\Attribute;


/**
 * This is the model class for table "attribute_value".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property integer $attribute_id
 * @property string $ext_key
 * @property integer $sort
 *
 * @property Attribute $attributeModel
 */
class BaseAttributeValue extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['attribute_id', 'sort'], 'integer'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'ext_key'], 'string', 'max' => 255],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
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
            'attribute_id' => 'Attribute ID',
            'ext_key' => 'Ext Key',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeModel()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }
}
