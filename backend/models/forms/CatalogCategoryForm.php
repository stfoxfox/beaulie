<?php

namespace backend\models\forms;

use common\models\File;
use Yii;
use yii\base\Model;
use common\models\CatalogCategory;
use common\models\CatalogCategoryDepartment;
use yii\web\UploadedFile;
use common\models\Department;
use yii\helpers\ArrayHelper;

/**
* This is the model class for CatalogCategory form.
*/
class CatalogCategoryForm extends Model
{
    public $title_ru;
    public $description_ru;
    public $business_description_ru;
    public $title_en;
    public $description_en;
    public $business_description_en;
    public $title_ua;
    public $description_ua;
    public $business_description_ua;
    public $title_kz;
    public $description_kz;
    public $business_description_kz;
    public $title_by;
    public $description_by;
    public $business_description_by;
    public $parent_catalog_category_id;
    public $file_id;
    public $business_file_id;
    public $sort;
    public $show_in_app;
    public $business_color;
    public $home_color;

    public $file_name_x;
    public $file_name_y;
    public $file_name_w;
    public $file_name_h;


    public $file_name;

    public $business_file_name_x;
    public $business_file_name_y;
    public $business_file_name_w;
    public $business_file_name_h;

    public $business_file_name;

    public $departments;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description_ru', 'description_en', 'description_ua', 'description_kz', 'description_by', 'business_description_ru', 'business_description_en', 'business_description_ua', 'business_description_kz', 'business_description_by'], 'string'],
            [['parent_catalog_category_id', 'file_id', 'sort'], 'integer'],
            [['show_in_app'], 'boolean'],
            [['created_at', 'updated_at', 'departments' ], 'safe'],
            [['title_ru', 'title_en', 'title_ua', 'title_kz', 'title_by', 'business_color', 'home_color'], 'string', 'max' => 255],
            [['parent_catalog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['parent_catalog_category_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['business_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['business_file_id' => 'id']],

            [['file_name_x','file_name_y','file_name_w','file_name_h', 'business_file_name_x','business_file_name_y','business_file_name_w','business_file_name_h'], 'safe'],

            [['file_name', 'business_file_name'], 'string', 'max' => 255],
            [['file_name', 'business_file_name'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],
       
        ];
    }

    /**
     * @param CatalogCategory $item
     */
    public function loadFromItem($item)
    {
        $this->title_ru = $item->title_ru;
        $this->description_ru = $item->description_ru;
        $this->business_description_ru = $item->business_description_ru;
        $this->title_en = $item->title_en;
        $this->description_en = $item->description_en;
        $this->business_description_en = $item->business_description_en;
        $this->title_ua = $item->title_ua;
        $this->description_ua = $item->description_ua;
        $this->business_description_ua = $item->business_description_ua;
        $this->title_kz = $item->title_kz;
        $this->description_kz = $item->description_kz;
        $this->business_description_kz = $item->business_description_kz;
        $this->title_by = $item->title_by;
        $this->description_by = $item->description_by;
        $this->business_description_by = $item->business_description_by;

        $this->parent_catalog_category_id = $item->parent_catalog_category_id;
        $this->file_id = $item->file_id;
        $this->business_file_id = $item->business_file_id;
        $this->sort = $item->sort;
        $this->show_in_app = $item->show_in_app;
        $this->business_color = $item->business_color;
        $this->home_color = $item->home_color;

        // $departments = CatalogCategoryDepartment::find()->where(['catalog_category_id' => $item->id])->all();
        // foreach($departments as $department){
        //     $this->departments[] = $department->department_id;
        // }
        $this->departments = ArrayHelper::getColumn($item->getDepartments()->asArray()->all(), 'id');
    }

    /**
     * @inheritdoc
     * @var CatalogCategory $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title_ru = $this->title_ru;
        $item->description_ru = $this->description_ru;
        $item->business_description_ru = $this->business_description_ru;
        $item->title_en = $this->title_en;
        $item->description_en = $this->description_en;
        $item->business_description_en = $this->business_description_en;
        $item->title_ua = $this->title_ua;
        $item->description_ua = $this->description_ua;
        $item->business_description_ua = $this->business_description_ua;
        $item->title_kz = $this->title_kz;
        $item->description_kz = $this->description_kz;
        $item->business_description_kz = $this->business_description_kz;
        $item->title_by = $this->title_by;
        $item->description_by = $this->description_by;
        $item->business_description_by = $this->business_description_by;


        $item->parent_catalog_category_id = $this->parent_catalog_category_id;

        $item->sort = $this->sort;
        $item->show_in_app = $this->show_in_app;
        $item->business_color = $this->business_color;
        $item->home_color = $this->home_color;

        if ($picture = UploadedFile::getInstance($this,'file_name')) {
            $item->file_id = File::saveFile(
                $picture,
                CatalogCategory::tableName(),
                $item->file_id,
                $this->file_name_x,
                $this->file_name_y,
                $this->file_name_h,
                $this->file_name_w
            );
        }

        if ($picture2 = UploadedFile::getInstance($this, 'business_file_name')) {
            $item->business_file_id = File::saveFile(
                $picture2,
                CatalogCategory::tableName(),
                $item->business_file_id,
                $this->business_file_name_x,
                $this->business_file_name_y,
                $this->business_file_name_h,
                $this->business_file_name_w
            );
        }

        if ($item->save()) {    
            $item->unlinkAll('departments', true);                    
            if(!empty($this->departments)){
                foreach($this->departments as $key => $value){
                    $item->link('departments', Department::findOne($value));
                }
            }            
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new CatalogCategory();

        $item->title_ru = $this->title_ru;
        $item->description_ru = $this->description_ru;
        $item->business_description_ru = $this->business_description_ru;
        $item->title_en = $this->title_en;
        $item->description_en = $this->description_en;
        $item->business_description_en = $this->business_description_en;
        $item->title_ua = $this->title_ua;
        $item->description_ua = $this->description_ua;
        $item->business_description_ua = $this->business_description_ua;
        $item->title_kz = $this->title_kz;
        $item->description_kz = $this->description_kz;
        $item->business_description_kz = $this->business_description_kz;
        $item->title_by = $this->title_by;
        $item->description_by = $this->description_by;
        $item->business_description_by = $this->business_description_by;

        $item->parent_catalog_category_id = $this->parent_catalog_category_id;

        $item->sort = $this->sort;
        $item->show_in_app = $this->show_in_app;
        $item->business_color = $this->business_color;
        $item->home_color = $this->home_color;

        if ($picture = UploadedFile::getInstance($this,'file_name')) {
            $item->file_id = File::saveFile(
                $picture,
                CatalogCategory::tableName(),
                $item->file_id,
                $this->file_name_x,
                $this->file_name_y,
                $this->file_name_h,
                $this->file_name_w
            );
        }

        if ($picture2 = UploadedFile::getInstance($this, 'business_file_name')) {
            $item->business_file_id = File::saveFile(
                $picture2,
                CatalogCategory::tableName(),
                $item->business_file_id,
                $this->business_file_name_x,
                $this->business_file_name_y,
                $this->business_file_name_h,
                $this->business_file_name_w
            );
        }

        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
