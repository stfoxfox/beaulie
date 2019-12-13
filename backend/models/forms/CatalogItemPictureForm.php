<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04.11.15
 * Time: 18:09
 */

namespace backend\models\forms;


use common\components\MyExtensions\MyFileSystem;
use common\components\MyExtensions\MyImagePublisher;
use common\models\BlogPostBlock;
use common\models\BlogPostBlockImage;
use common\models\CatalogItem;
use common\models\File;
use common\models\PageBlock;
use common\models\PageBlockImage;
use common\models\SpotPicture;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;

class CatalogItemPictureForm extends  Model
{


    public $picture;
    public $_model;
    public $catalog_item_id;
    public $image_id;
    public $x;
    public $y;
    public $w;
    public $h;


 

    public function rules()
    {
        return [


            [['x', 'y', 'w', 'h', 'catalog_item_id'], 'required'],
            [['picture','image_id'], 'safe'],
            [['picture'], 'string', 'max' => 255],
            [['picture'], 'file', 'extensions' => ['jpg', 'png'], 'maxFiles' => 1],


        ];
    }


    /**
     * @return File|null
     */
    public function createPicture()
    {
        if ($this->validate()) {

            if ($this->image_id && $this->image_id!=0){

                $item = File::findOne($this->image_id);

                if ($item){


                    $old_file=$item->uploadTo(CatalogItem::tableName(),'file_name');


                    $item->file_name = uniqid() . "_" . md5($old_file) . "." . pathinfo($old_file,PATHINFO_EXTENSION);

                    $item->save();


                    $cropImage = Image::crop($old_file, intval($this->w), intval($this->h), [intval($this->x), intval($this->y)]);
                    if ($cropImage) {

                        $cropImage->save(MyFileSystem::makeDirs($item->uploadTo(CatalogItem::tableName(),'file_name')));
                    }
                    unlink($old_file);
                    (new MyImagePublisher($item))->flushCache();
                }
            } else {

                $catalogItem = CatalogItem::findOne($this->catalog_item_id);
                $item = new File();
                $item->sort=0;
                $cropImage = false;
                if ($picture = UploadedFile::getInstance($this, 'picture')) {
                    $item->file_name = uniqid() . "_" . md5($picture->name) . "." . $picture->extension;
                    $cropImage = Image::crop($picture->tempName, intval($this->w), intval($this->h), [intval($this->x), intval($this->y)]);
                }

                if ($item->save()) {
                    if ($cropImage) {
                        $cropImage->save(MyFileSystem::makeDirs($item->uploadTo(CatalogItem::tableName(),'file_name')));
                    }
                    $catalogItem->link('files',$item);
                    return $item;
                }
            }

        }

        return null;
    }
}