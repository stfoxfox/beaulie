<?php

namespace common\models\gii;

use Yii;
use common\models\File;
use common\models\SiteSettings;



/**
 * This is the model class for table "site_settings".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text_key
 * @property integer $type
 * @property boolean $bool_value
 * @property string $string_value
 * @property string $text_value
 * @property string $text2_value
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property integer $number_value
 * @property integer $parent_id
 * @property integer $child_elements_type
 * @property integer $file_id
 *
 * @property File $file
 * @property SiteSettings $parent
 * @property SiteSettings[] $siteSettings
 */
class BaseSiteSettings extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'string_value', 'text_value', 'text2_value'], 'string'],
            [['type', 'sort', 'number_value', 'parent_id', 'child_elements_type', 'file_id'], 'integer'],
            [['bool_value'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'text_key'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SiteSettings::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'description' => 'Description',
            'text_key' => 'Text Key',
            'type' => 'Type',
            'bool_value' => 'Bool Value',
            'string_value' => 'String Value',
            'text_value' => 'Text Value',
            'text2_value' => 'Text2 Value',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'number_value' => 'Number Value',
            'parent_id' => 'Parent ID',
            'child_elements_type' => 'Child Elements Type',
            'file_id' => 'File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SiteSettings::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiteSettings()
    {
        return $this->hasMany(SiteSettings::className(), ['parent_id' => 'id']);
    }
}
