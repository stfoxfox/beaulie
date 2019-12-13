<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 13.08.15
 * Time: 19:31
 */
namespace common\components\MyExtensions;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class MyActiveRecord extends \yii\db\ActiveRecord {



    const MULTILANG_ATTR_NAME = "_ru";


    public function behaviors()
    {
        return [
            'ts_behavior'=>[
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
        ]
        ];
    }

    public static function getAttributeEnums($attribute) {
        $return = array();

        $model_reflection = new \ReflectionClass(get_called_class());


        foreach($model_reflection->getConstants() as $constant=>$value) {
            if (preg_match('/^'.strtoupper($attribute).'.+/', $constant)) {


                $return[$value] =  \Yii::t('models/'.strtolower($model_reflection->getShortName()),$constant);;

            }
        }


        return $return;
    }


    public function isAttributeEnumerable($attribute) {
        $ret = false;

        $model_reflection = new \ReflectionClass($this);
        foreach(array_keys($model_reflection->getConstants()) as $constant) {
            if (preg_match('/^'.strtoupper($attribute).'.+/', $constant)) {
                $ret = true;
            }
        }

        return $ret;
    }




    public function __get($attribute_name)
    {
        // Проверяем, если атрибут мультиязычный
        if ($this->_isAttributeMultilanguage($attribute_name)) {
            $attribute_for_current_language = $this->getAttributeForCurrentLanguage($attribute_name);

            $attribute_value = parent::__get($attribute_for_current_language);
            // Если значение атрибута для выбранного языка пустое, то берем для английского
            $attribute_value = trim($attribute_value);
            if (empty($attribute_value)) {

                return parent::__get($attribute_name . self::MULTILANG_ATTR_NAME);

            }

            return parent::__get($attribute_for_current_language);
        }

        return parent::__get($attribute_name);
    }


    private function _isAttributeMultilanguage($attribute_name)
    {

        if (in_array($attribute_name . self::MULTILANG_ATTR_NAME, $this->attributes())) {

            return true;
        }
        return false;
    }

    public function getAttributeForCurrentLanguage($attribute_name)
    {

        $current_lang = substr(\Yii::$app->language, 0,2);;

        if ($this->hasAttribute($attribute_name . '_'.$current_lang)) {

            return $attribute_name . '_'.$current_lang;

        }else {
            return $attribute_name . self::MULTILANG_ATTR_NAME;
        }


    }



}