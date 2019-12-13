<?php

use common\components\MyExtensions\MyImagePublisher;
?>

<p class="images-row content-list__section">
    <img src="<?= (new MyImagePublisher($model))->resizeInBox(640, 335, false, 'file_name')?>">
</p>
