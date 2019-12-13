<?php 

use common\components\MyExtensions\MyImagePublisher;
?>
<p class="images-row content-list__section">
    <span class="images-row__image">
        <img src="<?= (new MyImagePublisher($model))->resizeInBox(310, 160, false, 'first_image')?>" data-pagespeed-url-hash="283059488" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
    </span>
    <span class="images-row__image">
        <img src="<?= (new MyImagePublisher($model))->resizeInBox(310, 160, false, 'second_image')?>" data-pagespeed-url-hash="577559409" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
    </span>
</p>