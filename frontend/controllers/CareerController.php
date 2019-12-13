<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Page;
use common\models\SiteSettings;
use common\models\Vacancy;
use frontend\models\VacancyContactForm;
use frontend\models\VacancyForm;
use yii\web\NotFoundHttpException;
use Yii;

class CareerController extends FrontendController
{
    public function actionIndex()
    {
        $page = Page::findOne(['slug' => 'career']);
        if (!$page) {
            throw new NotFoundHttpException(Yii::t('app', 'Страницы не существует'));
        }

        $form = new VacancyForm();
        if ($form->load(Yii::$app->request->post()) && $form->submit()) {
            Yii::$app->session->setFlash('success', 'Вы успешно отправили заявку');
            return $this->refresh();
        }

        $contactForm = new VacancyContactForm();
        if (
            $contactForm->load(Yii::$app->request->post()) &&
            $contactForm->sendEmail()
        ) {
            Yii::$app->session->setFlash('success', 'Вы успешно отправили заявку');
            return $this->refresh();
        }

        $items = Vacancy::find()->where(['is_active' => true])->orderBy('sort')->all();

        return $this->render('index', [
            'form' => $form,
            'contactForm' => $contactForm,
            'page' => $page,
            'items' => $items
        ]);
    }
}