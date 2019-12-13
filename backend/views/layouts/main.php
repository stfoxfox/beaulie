<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\MainAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\MyAllert;
use \common\widgets\MenuWithIcons;
use yii\helpers\Url;

$asset = MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="fixed-navigation">


        <?php $this->beginBody() ?>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element"> <span>
                                </span>
                                <a  href="<?= Url::toRoute('site-settings/index') ?>">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= Yii::$app->user->identity->username ?></strong></span>
                                </a>
                            </div>
                            <div class="logo-element">
                                YKT
                            </div>
                        </li>


                        <?php
                        echo MenuWithIcons::widget([
                            'items' => [
                                // Important: you need to specify url as 'controller/action',
                                // not just as 'controller' even if default action is used.
                                //['label'=>'Панель управления' ,'url'=>['site/index'],'icon'=>'fa-th-large'],
                                // ['label'=>'Администраторы' ,'url'=>['backend-users/list'],'icon'=>'fa-th-large',],
                                ['label' => 'Каталог', 'url' => ['catalog/view'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'catalog'],
                                ['label' => 'Коллекции', 'url' => ['collection/index'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'collection'],
                                ['label' => 'Атрибуты', 'url' => ['attribute/index'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'attribute'],
                                ['label' => 'Фильтры', 'url' => ['filter/index'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'filter'],
                                ['label' => 'Страны', 'url' => ['country/index'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'country'],
                                ['label' => 'Магазины', 'url' => ['region/view'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'catalog'],
                                ['label' => 'Страницы', 'url' => ['page/index'], 'icon' => 'fa-file', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'page'],
                                ['label' => 'Администраторы', 'url' => ['backend-users/index'], 'icon' => 'fa-user', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'backend-users'],
                                ['label' => 'Управление языками', 'url' => ['language/index'], 'icon' => 'fa-user', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'backend-users'],
                                ['label' => 'Управление переводами', 'url' => ['translates/index'], 'icon' => 'fa-user', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'backend-users'],
                                ['label' => 'Настройки', 'url' => ['site-settings/index'], 'icon' => 'fa-cog', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'site-settings'],
                                ['label' => 'Вакансии', 'url' => ['vacancy/index'], 'icon' => 'fa-users', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'vacancy'],
                                ['label' => 'Отклики на вакансии', 'url' => ['vacancy-response/index'], 'icon' => 'fa-users', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'vacancy-response'],
                                ['label' => 'Бренды', 'url' => ['brand/index'], 'icon' => 'fa-list', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'brand'],
                                ['label' => 'Новости', 'url' => ['news/index'], 'icon' => 'fa-list', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'news'],
                                ['label' => 'Теги', 'url' => ['tag/index'], 'icon' => 'fa-list', 'visible' => Yii::$app->user->can('admin'), 'active' => \Yii::$app->controller->id == 'tag'],
                            ],
                            'options' => [
                                'class' => 'nav metismenu',
                                'id' => 'side-menu',
                            ],
                        ]);
                        ?>

                    </ul>

                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top  <?php if (!$this->context->show_header) { ?>white-bg<?php } ?>" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-success " href="#"><i class="fa fa-bars"></i> </a>

                        </div>
                        <ul class="nav navbar-top-links navbar-right">



                            <li>
                                <a data-method = 'post' href="<?= Url::toRoute('site/logout') ?>" >
                                    <i class="fa fa-sign-out"></i> Выйти
                                </a>
                            </li>

                        </ul>

                    </nav>
                </div>

                <?php if ($this->context->show_header) { ?>
                    <div class="row wrapper border-bottom white-bg page-heading">
                        <div class="col-lg-9">
                            <h2><?= isset($this->params['pageHeader']) ? $this->params['pageHeader'] : ""?></h2>

                            <?=
                            Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ])
                            ?>

                        </div>
                    </div>
                <?php } ?>
                <div class="wrapper wrapper-content">

                    <?= MyAllert::widget() ?>
                    <?= $content ?>

                </div>
                <div class="footer">
                    <div class="pull-right">

                    </div>
                    <div>
                        <strong>Copyright</strong> &copy; <?= date('Y') ?>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
