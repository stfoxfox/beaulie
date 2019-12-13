<?php
/* @var $model \frontend\models\VacancyForm */
/* @var $item \common\models\Vacancy */
use yii\helpers\Html;
?>
<?= Html::beginForm(['career/index'], 'post', [
        'class' => 'vacancy-page__form form',
        'enctype' => 'multipart/form-data',
]); ?>
    <?= Html::activeHiddenInput($model, 'vacancy_id', ['value' => $item->id]); ?>
    <?= Html::activeHiddenInput($model, 'department', ['value' => $item->department]); ?>
    <div class="form__row">
        <div class="form__col">
            <div class="form__field">
                <?= Html::activeTextInput($model, 'name', ['class' => 'form__input', 'required' => 'required']) ?>
                <label class="form__label"><?= Yii::t('app', 'Имя') ?></label>
            </div>
        </div>
        <div class="form__col">
            <div class="form__field">
                <?= Html::activeTextInput($model, 'surname', ['class' => 'form__input', 'required' => 'required']) ?>
                <label class="form__label"><?= Yii::t('app', 'Фамилия') ?></label>
            </div>
        </div>
    </div>
    <div class="form__row">
        <div class="form__col">
            <div class="form__field">
                <?= Html::activeTextInput($model, 'phone', ['class' => 'form__input input_phone', 'required' => 'required']) ?>
                <label class="form__label"><?= Yii::t('app', 'Телефон') ?></label>
            </div>
        </div>
        <div class="form__col">
            <div class="form__field">
                <?= Html::activeTextInput($model, 'email', ['class' => 'form__input input_mail', 'required' => 'required']) ?>
                <label class="form__label"><?= Yii::t('app', 'E-mail') ?></label>
            </div>
        </div>
    </div>
    <div class="form__row">
        <div class="form__field">
            <?= Html::activeTextarea($model, 'info', ['class' => 'form__input form_textarea', 'required' => 'required', 'rows' => 9]) ?>
            <label class="form__label"><?= Yii::t('app', 'Информация о вас') ?></label>
        </div>
    </div>
    <div class="form__additional">
        <div class="file-attach form__attach">
            <label class="link link_red file-attach__link"><?= Yii::t('app', 'Прикрепить резюме') ?>
                <?= Html::activeFileInput($model, 'file_name', ['class' => 'file-attach__input']) ?>
            </label>
            <div class="file-attach__desc"><?= Yii::t('app', 'Максимум 1 файл не более 5 мб <br /> Формат файла: pdf, docx, rtf, tiff') ?></div>
        </div>
        <button class="btn btn_red" type="submit"><?= Yii::t('app', 'ОТПРАВИТЬ') ?></button>
    </div>
<?= Html::endForm(); ?>

