<?php

namespace common\models;

use Yii;
use common\models\gii\BasePageBlock
;

/**
* This is the model class for table "page_block".
*/
class PageBlock extends BasePageBlock
{
    const BLOCKS = [
        1 => [
            'widgetClass' => 'common\widgets\text\TextWidget'
        ],
        3 => [
            'widgetClass' => 'common\widgets\gallery\GalleryWidget'
        ],
        4 => [
            'widgetClass' => 'common\widgets\brand\BrandsWidget'
        ],
        5 => [
            'widgetClass' => 'common\widgets\text\TechnologyWidget'
        ],
        6 => [
            'widgetClass' => 'common\widgets\text\TextLeftPhotoRightWidget'
        ],
        16 => [
            'widgetClass' => 'common\widgets\text\PhotoLeftTextRightWidget'
        ],
        7 => [
            'widgetClass' => 'common\widgets\text\ScreenPhotoLeftWidget'
        ],
        8 => [
            'widgetClass' => 'common\widgets\text\ScreenButtonWidget'
        ],
        9 => [
            'widgetClass' => 'common\widgets\text\PhotoBigSmallTextWidget'
        ],
        10 => [
            'widgetClass' => 'common\widgets\text\TextPhotoThreeTextWidget'
        ],
        11 => [
            'widgetClass' => 'common\widgets\gallery\GalleryTextWidget'
        ],
        12 => [
            'widgetClass' => 'common\widgets\gallery\SliderWidget'
        ],
        13 => [
            'widgetClass' => 'common\widgets\gallery\LogoWidget'
        ],
        14 => [
            'widgetClass' => 'common\widgets\shop\ShopWidget'
        ],
        15 => [
            'widgetClass' => 'common\widgets\item\CatalogItemWidget'
        ],
        17 => [
            'widgetClass' => 'common\widgets\news\NewsWidget'
        ],
        18 => [
            'widgetClass' => 'common\widgets\item\CatalogStylingWidget'
        ],
        20 => [
            'widgetClass' => 'common\widgets\item\StylingCareWidget'
        ],
        21 => [
            'widgetClass' => 'common\widgets\news\NewsBlockWidget'
        ],
        ////
        22 => [
            'widgetClass' => 'common\widgets\news\TextBlockWidget'
        ],
        23 => [
            'widgetClass' => 'common\widgets\news\ImageBlockWidget'
        ],
        24 => [
            'widgetClass' => 'common\widgets\news\VideoBlockWidget'
        ],
        25 => [
            'widgetClass' => 'common\widgets\news\TwoImageBlockWidget'
        ],
        26 => [
            'widgetClass' => 'common\widgets\news\LeftImageBlockWidget'
        ],
        27 => [
            'widgetClass' => 'common\widgets\news\RightImageBlockWidget'
        ],
    ];


    public function getBlockTemplateForBackend()
    {
        return self::BLOCKS[$this->type]['saveView'];
    }

    public function getDataWidget()
    {
        $data = json_decode($this->data);
        $widget = $data->class_name;
        if(isset($data->params))
            return $widget::widget([
                'params' => get_object_vars($data->params),
                'page_id' => $this->page_id,
                'block_id' => $this->id
            ]);
        else
            return $widget();
    }

    public function getWidgetClassName(){
        $data = json_decode($this->data);
        $widget = $data->class_name;
        if(isset($widget))
            return $widget;
        else
            return false;
    }

    public function getModelClassName(){
        $data = json_decode($this->data);
        $widget = $data->class_name;
        $modelClassName = $widget::getForm();
        if(isset($modelClassName))
            return $modelClassName;
        else
            return false;
    }

    public function getDataParams($lang = 'ru')
    {
        $dataParam = 'data_' . $lang;
        $data = json_decode($this->$dataParam);
        if(isset($data->params))
            return $data->params;
        else
            return new \stdClass();
    }

    public function deleteBlockImageField($imageField, $lang = 'ru')
    {
        $dataParam = 'data_' . $lang;
        $data = json_decode($this->$dataParam);
        if (isset($data->params))
        {
            $params = $data->params;
            $widgetClass = $data->class_name;
            $modelClass = $widgetClass::getForm();
            $model = new $modelClass();
            $photo_file = $model->uploadTo($imageField,$this->page_id,basename(str_replace('\\', '/', $widgetClass))).(empty($params->$imageField)?'':('/'.$params->$imageField));
            if (!empty($params->$imageField))
            {
                @unlink($photo_file);
                unset($params->$imageField);
            }
            $this->$dataParam = \yii\helpers\Json::encode(['class_name' => $widgetClass, 'params' => $params]);
            return $this->save();
        }
        else
            return false;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $modelClass = $this->modelClassName;
        $languages = Language::getActive();
        foreach ($languages as $language) {
            foreach ($modelClass::types() as $imageField => $inputType) {
                if($inputType == 'imageInput')
                    $this->deleteBlockImageField($imageField, $language);
            }
        }

        return true;
    }
}
