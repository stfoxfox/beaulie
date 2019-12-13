<?php

namespace common\widgets\news;

use common\models\News;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class NewsBlockWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\news\forms\NewsBlockWidgetForm';
    }

    public static function getBlockName(){
        return 'Новости';
    }

    public function init()
    {
        parent::init();
        if ($this->page_id == null)
            return false;
    }

    public function run()
    {
        $model  = $this->getModel();

        $items = News::find()->orderBy(['created_at' => SORT_DESC])->limit(3)->all();

        return $this->render('news_block', [
            'model'  => $model,
            'items' => $items
        ]);
    }
}