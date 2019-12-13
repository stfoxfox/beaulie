<?php
use frontend\assets\SearchAsset;

SearchAsset::register($this);
?>
<form class="main-search"  method="get">
    <div class="main-search__field">
        <input type="text" name="q" placeholder="Поиск по сайту">
        <div class="main-search__close"></div>
        <button class="main-search__btn btn btn_red" type="submit">
            <span class="btn__icon">
              <svg>
                  <use xlink:href="#icon-search-white"></use>
              </svg>
            </span><span>Найти</span>
        </button>
    </div>
    <div class="main-search__results-wrapper"></div>
</form>