<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07/06/2017
 * Time: 00:29
 */

namespace console\controllers;


use common\models\Page;
use common\models\SiteSettings;
use yii\console\Controller;

class SettingsController extends Controller
{
    /**
     * Run with first deploy
     */
    public function actionGenerateMainPage()
    {
        $page= new Page();
        $page->is_index_page=true;
        $page->title_ru ="Главная страница";
        $page->slug ="index";

        if (!$page->save()) {
            print_r($page->getErrors());
        }
    }

    /**
     * Run with first deploy
     */
    public function actionAddPages()
    {
        $this->addPage('Карьера', 'career');
    }

    /**
     * @param $title
     * @param $slug
     * @param bool $isIndex
     */
    public function addPage($title, $slug, $isIndex = false)
    {
        if (!Page::findOne(['slug' => $slug])) {
            $page= new Page();
            $page->is_index_page = $isIndex;
            $page->title_ru = $title;
            $page->slug = $slug;

            if (!$page->save()) {
                print_r($page->getErrors());
            }
        } else {
            echo "Page `{$slug}` already exist\n";
        }

    }

    /**
     * Run with first deploy
     */
    public function actionInitCreate()
    {
        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeString;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();

        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeText;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();

        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeImage;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();

        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeNumber;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();

    }

    /**
     * List all settings
     */
    public function actionList(){
        /**
         * @var SiteSettings[] $settings
         */
        $settings = SiteSettings::find()->where('parent_id is null')->all();
        foreach ($settings as $var){
            echo "ID: ".$var->id." | KEY: ".$var->text_key." | ".$var->title."\n";
        }

    }

    /**
     * @param $key
     * @param $value
     * @param string $title
     * @param int $sort
     * @param int $type
     */
    public function actionAdd($key, $value, $title = '', $sort = 1,$type=SiteSettings::SiteSettings_TypeString)
    {
        $setting = new SiteSettings();
        $setting->title = $title;
        $setting->text_key = $key;
        $setting->type = $type;
        $setting->string_value = $value;
        $setting->sort = $sort;
        echo $setting->save() ? 'Saved' : 'Errors: ' . implode(' ', $setting->getFirstErrors());
    }

    /**
     *
     */
    public  function actionDrop()
    {
        SiteSettings::deleteAll();
    }
}