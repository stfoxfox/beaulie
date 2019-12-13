<?php
/* @var $items \common\models\Vacancy[] */
/* @var $page \common\models\Page */
/* @var $this \yii\web\View */
/* @var $form \frontend\models\VacancyForm */
/* @var $contactForm \frontend\models\ContactForm */
use common\components\MyExtensions\MyImagePublisher;

$this->title = Yii::t('app', 'Карьера');
?>
<main class="page page_inner vacancy-page js-widget" onclick="return {vacancyPage: {}}">
    <div class="page-layout page-layout_size_2">
        <div class="banner banner_blue" style="background: <?= $page->banner_color ?>">
            <div class="banner__main">
                <div class="banner__title"><?= $page->title ?></div>
                <div class="banner__text"><?= $page->banner_text ?></div>
                <div class="banner__links"><a class="btn banner__btn" href="#"><?= Yii::t('app', 'Связаться') ?></a></div>
            </div>
            <div class="banner__image" style="<?= $page->bannerFile ? 'background-image' : 'background' ?>: <?= $page->bannerFile ? 'url(' . (new MyImagePublisher($page->bannerFile))->resizeInBox(450, 300, false, 'file_name', 'page') . ')': $page->banner_color ?>;"></div>
        </div>

        <?= $this->render('@frontend/views/common/_pageBlocks', ['page' => $page]) ?>

        <div class="vacancy-page__content">
            <div class="accordion js-widget" onclick="return {accordion: {}}">
                <?php foreach ($items as $item): ?>
                <div class="accordion__title">
                    <div class="accordion__icon"></div>
                    <div class="page-grid">
                        <div class="page-grid__unit"><span class="accordion__link"><?= $item->title ?></span></div>
                        <div class="page-grid__unit"><span class="text text_small text_gray"><?= $item->department ?></span></div>
                    </div>
                </div>
                <div class="accordion__content">
                    <div class="page-grid">
                        <div class="page-grid__unit"></div>
                        <div class="page-grid__unit">
                            <div class="expand js-widget" onclick="return {expand: {}}">
                                <div class="expand__title"><?= Yii::t('app', 'Обязанности') ?>:</div>
                                <div class="expand__content">
                                    <ul class="list">
                                        <?php foreach ($item->getByLines('description') as $line): ?>
                                            <li class="list__item"><?= $line ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="expand__title"><?= Yii::t('app', 'Требования') ?>:</div>
                                <div class="expand__content">
                                    <ul class="list">
                                        <?php foreach ($item->getByLines('requirements') as $line): ?>
                                            <li class="list__item"><?= $line ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="expand__title"><?= Yii::t('app', 'Условия') ?>:</div>
                                <div class="expand__content">
                                    <ul class="list">
                                        <?php foreach ($item->getByLines('conditions') as $line): ?>
                                            <li class="list__item"><?= $line ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?= $this->render('_form', ['model' => $form, 'item' => $item]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?= $this->render('_bigForm', ['model' => $contactForm]) ?>
        </div>
    </div>
</main>
<?php if (Yii::$app->session->getFlash('success')): ?>
    <?php $this->registerJs('
      $.magnificPopup.open({
        items: {
          src: "#thanks-popup-2"
        }
      });
    ', \yii\web\View::POS_END); ?>
<?php endif; ?>