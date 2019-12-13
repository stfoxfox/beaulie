<?php
/**
 * @var \common\models\CatalogCategory[] $items
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список</h5>
                <div class="pull-right">
                    <a href="<?= Url::to(['add-group',]) ?>"><i class="fa fa-plus"></i> Добавить группу фильтров</a>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item->title ?></td>
                        <td>
                            <?= Html::a('Редактировать группы', ['view-category', 'id' => $item->id]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>