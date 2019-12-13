<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 13.08.15
 * Time: 19:31
 */
namespace common\components\MyExtensions;

abstract class MyWidget extends \yii\base\Widget implements MyWidgetInterface{

    abstract public static function getForm();
    public $added_id;
    public $page_id;
    public $block_id;
    public $lang;
    public $params;

    public function backendCreate()
    {
        $model_class = $this->form;
        $model = new $model_class();
        return \Yii::$app->controller->renderAjax('@backend/views/page/add_widget',[
            'model' => $model,
            'added_id' => $this->added_id,
            'page_id' => $this->page_id,
            'lang' => $this->lang,
            'class_name' => $this->className(),
        ]);
    }

    public function backendView($page_block)
    {
        $model_class = $this->form;
        $model = new $model_class();
        $model->page_id = $page_block->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = get_object_vars($this->params);
        return $this->render('@backend/views/page/view_widget',[
            'model' => $model,
            'class_name' => $this->className(),
            'page_block' => $page_block,
        ]);
    }

    protected function getModel()
    {
        $class = $this->form;
        $model = new $class();
        $model->page_id = $this->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = $this->params;

        return $model;
    }
}