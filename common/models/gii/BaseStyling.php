<?php

namespace common\models\gii;

use common\models\File;
use common\models\CatalogCategory;
use Yii;


/**
 * This is the model class for table "styling".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $file_id
 * @property integer $image_id
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property string $subtitle_ru
 * @property string $subtitle_en
 * @property string $subtitle_ua
 * @property string $subtitle_kz
 * @property string $subtitle_by
 * @property string $text_ru
 * @property string $text_en
 * @property string $text_ua
 * @property string $text_kz
 * @property string $text_by
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 */
class BaseStyling extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'styling';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['text_ru', 'text_en', 'text_ua', 'text_kz', 'text_by',], 'string'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by',], 'string'],
            [['subtitle_ru', 'subtitle_en', 'subtitle_ua', 'subtitle_kz', 'subtitle_by',], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_id'], 'exist', 'targetClass' => BaseFile::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['image_id'], 'exist', 'targetClass' => BaseFile::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['category_id'], 'exist', 'targetClass' => BaseCatalogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_id' => 'File ID',
            'image_id' => 'Image ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'text' => 'Text',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
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
    public function getImage()
    {
        return $this->hasOne(File::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BaseCatalogCategory::className(), ['id' => 'category_id']);
    }
}
