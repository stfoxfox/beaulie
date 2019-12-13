<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06/08/2017
 * Time: 21:27
 */

namespace backend\models\forms;


use common\models\File;
use common\models\SiteSettings;
use common\components\MyExtensions\MyFileSystem;
use yii\base\Model;
use yii\web\UploadedFile;

class SiteSettingsForm extends Model
{

    public $file_name;
    public $file_name_x;
    public $file_name_y;
    public $file_name_w;
    public $file_name_h;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['file_name'], 'safe'],
            [['file_name'], 'string', 'max' => 255],


            [['file_name_x','file_name_y','file_name_w','file_name_h'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],


        ];
    }


    public function loadFromItem($item){





    }


    /**
     * @param SiteSettings $item
     * @return bool|null
     */
    public function edit($item){


        if (!$this->validate()) {
            return false;
        }





        if($file_name=UploadedFile::getInstance($this,'file_name')) {

            $item->file_id= File::saveFile(
                $file_name, SiteSettings::tableName(),
                $item->file_id,
                $this->file_name_x,
                $this->file_name_y,
                $this->file_name_h,
                $this->file_name_w
            );

        }


        if ($item->save()){


            return true;
        }

        return null;

    }


    public function create()
    {
        if (!$this->validate()) {
            return null;
        }


        return null;
    }

}