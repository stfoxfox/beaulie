<?php

use yii\db\Migration;
use common\models\Page;

class m171005_112814_create_pages extends Migration
{
    public function safeUp()
    {
        $page = Page::findOne(['slug' => 'career']);
        if (!$page) {
            $page = new Page([
                'title_ru' => 'Карьера',
                'slug' => 'career',
                'description_ru' => 'Карьера',
                'banner_text_ru' => 'Карьера'
            ]);
            echo ($page->save() ? 'Страница карьера создана' : 'Страница брендов не создана: ' . implode(', ', $page->getFirstErrors())) . "\n";
        }

        $page = Page::findOne(['slug' => 'company']);
        if (!$page) {
            $page = new Page([
                'title_ru' => 'Компания',
                'slug' => 'company',
                'description_ru' => 'Компания',
                'banner_text_ru' => 'Компания'
            ]);
            echo ($page->save() ? 'Страница компании создана' : 'Страница брендов не создана: ' . implode(', ', $page->getFirstErrors())) . "\n";
        }

        $page = Page::findOne(['slug' => 'brands']);
        if (!$page) {
            $page = new Page([
                'title_ru' => 'Бренды',
                'slug' => 'brands',
                'description_ru' => 'Бренды',
                'banner_text_ru' => 'Бренды'
            ]);
            echo ($page->save() ? 'Страница бренды создана' : 'Страница брендов не создана: ' . implode(', ', $page->getFirstErrors())) . "\n";
        }
    }

    public function safeDown()
    {
        $page = Page::findOne(['slug' => 'career']);
        if ($page) $page->delete();
        $page = Page::findOne(['slug' => 'company']);
        if ($page) $page->delete();
        $page = Page::findOne(['slug' => 'brands']);
        if ($page) $page->delete();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171005_112814_create_pages cannot be reverted.\n";

        return false;
    }
    */
}
