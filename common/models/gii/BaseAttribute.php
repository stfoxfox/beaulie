<?php

namespace common\models\gii;

use common\models\AttributeValue;
use Yii;


/**
 * This is the model class for table "attribute".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property string $ext_key
 * @property string $icon_type
 * @property boolean $show_in_collection
 * @property boolean $show_in_list
 * @property string $measure
 * @property integer $type
 * @property integer $sort
 * @property boolean $show_in_catalog_item
 * @property boolean $show_collection_icon
 *
 * @property AttributeValue[] $attributeValues
 */
class BaseAttribute extends \common\components\MyExtensions\MyActiveRecord
{
    const TYPE_STRING = 10;
    const TYPE_BOOL   = 20;
    const TYPE_NUMBER = 30;
    const TYPE_SELECT = 40;

    public $show_in_collection;
    public $show_in_list;
    public $show_in_catalog_item;
    public $show_collection_icon;

    /**
     * @return array
     */
    public static function typeLabels()
    {
        return [
            self::TYPE_STRING => Yii::t('app', 'Строка'),
            self::TYPE_BOOL => Yii::t('app', 'Булев'),
            self::TYPE_NUMBER => Yii::t('app', 'Число'),
            self::TYPE_SELECT => Yii::t('app', 'Список'),
        ];
    }


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
        return 'attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['show_in_collection', 'show_in_list', 'show_in_catalog_item', 'show_collection_icon'], 'boolean'],
            [['type', 'sort'], 'integer'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'ext_key', 'icon_type', 'measure'], 'string', 'max' => 255],
            [['standard_ru', 'standard_en', 'standard_ua', 'standard_kz', 'standard_by'], 'string', 'max' => 255]
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
            'ext_key' => 'Ext Key',
            'icon_type' => 'Icon Type',
            'show_in_collection' => 'Show In Collection',
            'show_collection_icon' => 'Show Collection Icon',
            'show_in_list' => 'Show In List',
            'measure' => 'Measure',
            'type' => 'Type',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['attribute_id' => 'id']);
    }
}
