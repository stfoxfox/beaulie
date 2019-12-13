<?php

namespace common\models;

use Yii;
use common\models\gii\BaseSiteSettings
;

/**
* This is the model class for table "site_settings".
*/
class SiteSettings extends BaseSiteSettings
{


    const SiteSettings_TypeText=1;
    const SiteSettings_TypeBool=2;
    const SiteSettings_TypeNumber=3;
    const SiteSettings_TypeFile=4;
    const SiteSettings_TypeImage=5;
    const SiteSettings_TypeString=6;
    const SiteSettings_TypeArray=7;
    const SiteSettings_TypeGallery=8;



    public function getEditableType(){

        switch ($this->type){


            case  self::SiteSettings_TypeBool:{

                return "boolean";
            }
            case self::SiteSettings_TypeString:
            {
                return "text";
            }
            case self::SiteSettings_TypeText:
            {
                return "textarea";
            }
                break;
            case self::SiteSettings_TypeNumber:
            {
                return "number";
            }
                break;
            default:
                return false;






        }



    }

    public function isBaseType(){


        switch ($this->type){


            case  self::SiteSettings_TypeBool:
            case self::SiteSettings_TypeString:
            case self::SiteSettings_TypeText:
            case self::SiteSettings_TypeNumber:
            {
                return true;
            }
                break;
            default:
                return false;






        }


    }

    /**
     * @param $key
     * @return bool|int|string
     */
    public static function get($key)
    {
        $model = self::findOne(['text_key' => $key]);
        if ($model) {
            return $model->getValue();
        } else
            return false;
    }

    public function getValue(){



        switch ($this->type){

            case self::SiteSettings_TypeArray:{

                return "Набор элементов, для просмотра перейдите в режим редактирования";
            }
                break;
            case  self::SiteSettings_TypeBool:{

                if ($this->bool_value){
                    return "Да";
                }else{

                    return "Нет";
                }
            }
                break;
            case self::SiteSettings_TypeString:
            {
                return $this->string_value;
            }
                break;
            case self::SiteSettings_TypeText:
            {
                return $this->text_value;
            }
                break;
            case self::SiteSettings_TypeNumber:
            {
                return $this->number_value;
            }
                break;
        }
    }

    /**
     * @return \yii\db\ActiveQuery|null
     */
    public function getFiles()
    {
        if ($this->type === self::SiteSettings_TypeGallery) {
            return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('site_settings_image', ['site_settings_id' => 'id']);
        }

        return null;
    }
    

}
