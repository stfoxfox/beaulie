<?php

namespace backend\controllers;

use common\components\controllers\BackendController;
use yii\filters\AccessControl;
use common\models\VacancyResponse;
use yii\web\ForbiddenHttpException;

class VacancyResponseController extends BackendController
{
    /**
     * @inheritdoc
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
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Отклики на вакансии');
        $items = VacancyResponse::find()->all();
        return $this->render('index', [
            'items' => $items
        ]);
    }

    /**
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionChangeStatus()
    {
        if (!\Yii::$app->request->isAjax || !\Yii::$app->request->isPost)
            throw new ForbiddenHttpException;

        $model = VacancyResponse::findOne(\Yii::$app->request->post('pk'));
        $model->status = \Yii::$app->request->post('value');

        return $this->sendJSONResponse([
            'result' => $model->save(),
            'errors' => $model->getErrors()
        ]);
    }
}