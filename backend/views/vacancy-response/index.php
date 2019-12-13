<?php
/**
 * @var $this \yii\web\View
 * @var $items \common\models\VacancyResponse[]
 */

use backend\widgets\editable\EditableWidget;
use yii\helpers\Html;
use common\components\MyExtensions\MyFilePublisher;

$this->title = 'Отклики на вакансии';

?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список откликов</h5>
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Имя фамилия</th>
                                <th>Телефон</th>
                                <th>Email</th>
                                <th>Инфо</th>
                                <th>Резюме</th>
                                <th>Вакансия</th>
                                <th>Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /** @var \common\models\VacancyResponse $item */
                            foreach ($items as $item):
                                ?>
                                <tr sort-id="<?= $item->id ?>">
                                    <td><?= $item->name .  ' ' . $item->surname ?></td>
                                    <td><?= $item->phone ?></td>
                                    <td><?= $item->email ?></td>
                                    <td><?= $item->info ?></td>
                                    <td><?= $item->file ? Html::a('скачать', (new MyFilePublisher($item->file))->publishFile('file_name', 'vacancy-response')) : 'не прикреплено' ?></td>
                                    <td><?= Html::a($item->vacancy->title_ru, ['vacancy/edit', 'id' => $item->vacancy->id]) ?></td>
                                    <td><?=
                                        EditableWidget::widget([
                                            'name' => 'status',
                                            'value' => $item->getStatusLabel(),
                                            'pk' => $item->id,
                                            'url' => ['change-status'],
                                            'type' => 'select',
                                            'source' => $item::statusLabelsForEditable()
                                        ])
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
