<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19/07/2017
 * Time: 14:56
 */

namespace console\controllers;


use common\models\Language;
use yii\console\Controller;

class LangController extends Controller
{

    public function actionAddLanguages(){



        $enLang =new Language();
        $enLang->code="en";
        $enLang->title="Английский";
        $enLang->save();



        $enLang =new Language();
        $enLang->code="ru";
        $enLang->title="Русский";
        $enLang->save();



        $enLang =new Language();
        $enLang->code="ua";
        $enLang->title="Украинский";
        $enLang->save();



        $enLang =new Language();
        $enLang->code="kz";
        $enLang->title="Казахский";
        $enLang->save();



        $enLang =new Language();
        $enLang->code="by";
        $enLang->title="Белорусский";
        $enLang->save();




    }



    public function actionInit(){



        echo "Применить миграции прееводов[y/n]:\n";
        echo exec ('php '.\Yii::getAlias("@backend").'/../yii migrate --migrationPath="@yii/i18n/migrations 2>&1" ', $output) ;
        echo "\n";
        echo "Импортируем переводы\n";

        echo exec ('php '.\Yii::getAlias("@backend").'/../yii message/extract @frontend/message-extract-config.php  2>&1',$output) ;
        echo "\n";

    }

}