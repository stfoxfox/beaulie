<?php

namespace common\models\gii;

use Yii;
use common\models\PageBlockImage;
use common\models\PageBlock;


/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $file_name
 * @property boolean $is_img
 * @property string $title
 * @property string $description
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PageBlockImage[] $pageBlockImages
 * @property PageBlock[] $parents
 */
class BaseFile extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name'], 'required'],
            [['is_img'], 'boolean'],
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'is_img' => 'Is Img',
            'title' => 'Title',
            'description' => 'Description',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlockImages()
    {
        return $this->hasMany(PageBlockImage::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(PageBlock::className(), ['id' => 'parent_id'])->viaTable('page_block_image', ['file_id' => 'id']);
    }
}
