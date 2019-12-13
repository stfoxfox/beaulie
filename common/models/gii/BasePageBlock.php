<?php

namespace common\models\gii;

use Yii;
use common\models\Page;
use common\models\PageBlockImage;
use common\models\File;


/**
 * This is the model class for table "page_block".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $type
 * @property integer $sort
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 * @property string $block_name
 *
 * @property Page $page
 * @property PageBlockImage[] $pageBlockImages
 * @property File[] $files
 */
class BasePageBlock extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'type', 'sort'], 'integer'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['block_name'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'type' => 'Type',
            'sort' => 'Sort',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'block_name' => 'Block Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('page_block_image', ['parent_id' => 'id']);
    }
}
