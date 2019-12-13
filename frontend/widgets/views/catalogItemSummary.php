<?php
/**
 * @var \common\models\CatalogCategory $currentCategory
 * @var integer $homeCount
 * @var integer $businessCount
 */

use yii\helpers\Url;
?>
<div class="aside-nav__item aside-nav__item_active">
    <a href="<?= Url::toRoute(['catalog/index', 'id' => $currentCategory->id, 'is_home' => true]) ?>"><strong><?= Yii::t('app.layout.aside', 'Для себя') ?></strong></a>
    <br><a href="<?= Url::toRoute(['catalog/index', 'id' => $currentCategory->id, 'is_home' => false]) ?>"><strong><?= Yii::t('app.layout.aside', 'Для бизнеса') ?></strong></a>
</div>