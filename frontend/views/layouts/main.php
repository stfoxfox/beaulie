<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\FavoritesAsset;
use frontend\widgets\Favorites;

$bundle = AppAsset::register($this);
FavoritesAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="page__inner">
    <div class="menu-toggle js-widget" onclick="return {'menuToggle': {}}"></div>
    <?= $this->render('_aside', [
        'bundle' => $bundle
    ]) ?>

    <div class="page-wrap">
        <?= Favorites::widget() ?>
        <div class="page-container">
            <?= $this->render('_header') ?>
            <?= $this->render('_search', [
                'bundle' => $bundle
            ]) ?>
            <?= $content ?>
            <?= $this->render('_footer') ?>
            <?= $this->render('_popups', [
                'bundle' => $bundle
            ])?>
        </div>
    </div>
</div>
<?= $this->render('_icons') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
