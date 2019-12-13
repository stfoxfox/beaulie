<?php

namespace frontend\controllers;

use Yii;
use common\components\controllers\FrontendController;
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;
use common\models\CatalogCategory;
use common\models\News;
use common\models\Page;
use common\models\Styling;
use common\models\Tag;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class NewsController extends FrontendController
{
    public function actionIndex()
    {
        $page = Page::findOne(['slug' => 'news']);
        if (!$page)
            throw new NotFoundHttpException;

        return $this->render('index', [
            'page' => $page,
        ]);
    }

    public function actionList(){

        $categories = CatalogCategory::find()->with('news')->all();
        $tags = Tag::find()->with('news')->orderBy('sort')->all();
        $allNews = News::find()->all();
        $newsList = News::find()->orderBy(['created_at' => SORT_DESC])->limit(10)->all();

        return $this->render('news-list', [
            // 'page' => $page,
            'categories' => $categories,
            'tags' => $tags,
            'newsList' => $newsList,
            'pages' => intdiv(count($allNews), 10) + 1,
        ]);
    }

    public function actionFilter(){
        $page = 1;
        $searchParams = Yii::$app->request->post();
        $allNews = News::find()->all();
        
        $newsList = News::find()->joinWith([
            'tags' => function($query) use($searchParams){
                if(isset($searchParams['tag'])){
                    $query->andWhere(['tag.id' => $searchParams['tag']]);
                }                
            },
            'catalogCategories' => function($query) use($searchParams){
                if(isset($searchParams['type']) && !empty($searchParams['type'])){
                    $query->andWhere(['like', 'catalog_category.title_ru', $searchParams['type']]);
                }
            }
        ]);
        if(isset($searchParams['month']) && !empty($searchParams['year'])){
            $newsList->andWhere(["date_part('month', news.created_at)" => $searchParams['month']]);
        }


        if(isset($searchParams['year']) && !empty($searchParams['year'])){
            $newsList->andWhere(["date_part('year', news.created_at)" => $searchParams['year']]);
        }

        if(isset($searchParams['page']) && !empty($searchParams['page'])){
            $page = $searchParams['page'];
        }

        $newsList = $newsList->orderBy(['news.created_at' => SORT_DESC])->limit(10)->offset(($page-1) * 10)->all();
        $result = [];
        foreach($newsList as $news){
            if($news !== null){
                $tags = [];
                if(isset($news->tags)){
                    foreach($news->tags as $tag){
                        $tags[] = $tag->title_ru;
                    }
                }

                $link = ['link' => '', 'text' => ''];
                if(isset($news->catelogCategories[0])){
                    $category = $news->catalogCategories[0];
                    $link = ['link' => Url::toRoute(['catalog/view', 'id' => $category->id]), 'text' => $category->title_ru];
                }

                $content = '';
                
                $page = $news->page;
                if (!empty($page->pageBlocks)){
                    foreach ($page->pageBlocks as $key => $block){
                        $content .= $block->dataWidget;
                    }
                }
                
                $result['news'][] = [
                    'title' => $news->title_ru,
                    'img' => (new MyImagePublisher($news->file))->resizeInBox(140, 140, false, 'file_name', 'news'),
                    'date' => MyHelper::formatDate($news->created_at),
                    'content' => $content,
                    'tags' => $tags,
                    'link' => $link
                ];
            }
        }
        
        $result['pages'] = intdiv(count($allNews), 10) + 1;

        return Json::encode($result);
    }
}