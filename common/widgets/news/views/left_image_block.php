<?php

use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;
?>
<section class="page-section">
    <div class="page-layout page-layout_size_2">
        <div class="content-row">
            <div class="content-row__col fs-0">
                <img src="<?= (new MyImagePublisher($model))->resizeInBox(480, 480, false, 'image')?>">
            </div>
            <div class="content-row__col content-row__col_flex">
                <div class="content-row__wrap">
                    <h2><?= $model->title?></h2>
                    <p class="text text_size_2"><?= $model->text ?></p>
                </div>
                <div class="content-row__wrap news__buttons"><a class="btn" href="#">Подробнее</a></div>
            </div>
        </div>
    </div>
</section>