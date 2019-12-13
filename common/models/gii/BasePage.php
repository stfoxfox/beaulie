<?php

namespace common\models\gii;

use common\models\File;
use Yii;
use common\models\PageBlock;


/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $title_kz
 * @property string $title_by
 * @property string $description_ru
 * @property string $description_en
 * @property string $description_ua
 * @property string $description_kz
 * @property string $description_by
 * @property string $html_text_ru
 * @property string $html_text_en
 * @property string $html_text_ua
 * @property string $html_text_kz
 * @property string $html_text_by
 * @property boolean $is_index_page
 * @property boolean $is_internal
 * @property string $created_at
 * @property string $updated_at
 *
 * @property string $banner_color
 * @property integer $banner_file_id
 * @property string $banner_text_ru
 * @property string $banner_text_en
 * @property string $banner_text_ua
 * @property string $banner_text_kz
 * @property string $banner_text_by
 *
 * @property PageBlock[] $pageBlocks
 * @property File $bannerFile
 */
class BasePage extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['html_text_ru', 'html_text_en', 'html_text_ua', 'html_text_kz', 'html_text_by', 'banner_text_ru', 'banner_text_en', 'banner_text_ua', 'banner_text_kz', 'banner_text_by'], 'string'],
            [['is_index_page', 'is_internal'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['banner_file_id'], 'exist', 'targetClass' => BaseFile::className(), 'targetAttribute' => ['banner_file_id' => 'id']],
            [['slug', 'title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'description_ru', 'description_en', 'description_ua', 'description_kz', 'description_by', 'banner_color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'description' => 'Description',
            'html_text' => 'Html Text',
            'is_index_page' => 'Is Index Page',
            'is_internal' => 'Is Internal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'banner_color' => 'Banner color',
            'banner_file_id' => 'Banner file',
            'banner_text' => 'Banner text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlocks()
    {
        return $this->hasMany(PageBlock::className(), ['page_id' => 'id'])->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerFile()
    {
        return $this->hasOne(BaseFile::className(), ['id' => 'banner_file_id']);
    }
}
