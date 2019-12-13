<?php

namespace common\models\gii;

use common\models\File;
use Yii;


/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $about_ru
 * @property string $title_en
 * @property string $about_en
 * @property string $title_kz
 * @property string $about_kz
 * @property string $title_ua
 * @property string $about_ua
 * @property string $title_by
 * @property string $about_by
 * @property integer $sort
 * @property integer $file_id
 * @property integer $brand_file_id
 * @property string $tags
 * @property boolean $show_on_page
 *
 * @property File $file
 * @property File $brandFile
 */
class BaseBrand extends \common\components\MyExtensions\MyActiveRecord
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
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['about_ru', 'about_en', 'about_kz', 'about_ua', 'about_by', 'tags'], 'string'],
            [['sort'], 'integer'],
            [['show_on_page'], 'boolean'],
            [['file_id'], 'exist', 'targetClass' => BaseFile::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['brand_file_id'], 'exist', 'targetClass' => BaseFile::className(), 'targetAttribute' => ['brand_file_id' => 'id']],
            [['title_ru', 'title_en', 'title_kz', 'title_ua', 'title_by'], 'string', 'max' => 255],
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
            'about_ru' => 'About Ru',
            'title_en' => 'Title En',
            'about_en' => 'About En',
            'title_kz' => 'Title Kz',
            'about_kz' => 'About Kz',
            'title_ua' => 'Title Ua',
            'about_ua' => 'About Ua',
            'title_by' => 'Title By',
            'about_by' => 'About By',
            'logo_file_name' => 'Logo File Name',
            'file_name' => 'File Name',
            'sort' => 'Sort',
            'tags' => 'Tags',
            'show_on_page' => 'Show on page'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(BaseFile::className(), ['id' => 'file_id']);
    }

    public function getBrandFile()
    {
        return $this->hasOne(BaseFile::className(), ['id' => 'brand_file_id']);
    }
}
