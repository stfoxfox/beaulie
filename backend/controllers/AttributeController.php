<?php

namespace backend\controllers;

use backend\models\forms\AttributeValueForm;
use common\components\controllers\BackendController;
use common\models\Attribute;
use common\models\AttributeValue;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class AttributeController extends BackendController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\AttributeForm',
                'page_header' => 'Добавление атрибута',
                'breadcrumbs' => [
                    ['label' => 'Управление атрибутами', 'url' => ['attribute/index']]
                ]
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\AttributeForm',
                '_model' => Attribute::className(),
                'page_header' => 'Изменение атрибута',
                'breadcrumbs' => [
                    ['label' => 'Управление атрибутами', 'url' => ['attribute/index']]
                ]
            ],
            'dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Attribute::className(),
            ],
            'dell-value' => [
                'class' => 'common\components\actions\Dell',
                '_model' => AttributeValue::className(),
            ],
            'edit-value' => [
                'class' => 'common\components\actions\SaveFieldData',
                '_model' => AttributeValue::className()
            ],
            'sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => Attribute::className()
            ],
            'sort-values' => [
                'class' => 'common\components\actions\Sort',
                '_model' => AttributeValue::className()
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Атрибуты');
        $items = Attribute::find()->orderBy('sort')->all();

        return $this->render('index', [
            'items' => $items
        ]);
    }

    /**
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAddValue($id)
    {
        $attribute = Attribute::findOne($id);
        if (!$attribute)
            throw new NotFoundHttpException;

        $this->setTitleAndBreadcrumbs('Добавление значения для атрибута: ' . $attribute->title_ru, [
            ['label' => 'Управление атрибутами', 'url' => ['attribute/index']],
            ['label' => 'Изменение атрибута: ' . $attribute->title_ru, 'url' => ['attribute/edit', 'id' => $id]],
        ]);

        $model = new AttributeValueForm(['attribute_id' => $id]);
        if ($model->load(\Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['edit', 'id' => $id]);
        }

        return $this->render('add-value', [
            'formItem' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionGetValues($id)
    {
        $model = Attribute::findOne([
            'id'   => $id,
            'type' => Attribute::TYPE_SELECT
        ]);

        $result['error'] = false;
        if ($model) {
            $result['data'] = AttributeValue::getList($model->id);
        }

        return $this->sendJSONResponse($result);
    }
}