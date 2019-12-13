;(function ($) {
  'use strict';
  var ajaxSuccess = function(action, json, id) {
    switch (action) {
      case 'add':
        var favList = $('.fav-list');
        $('.page-container').css('transform', 'translateY(0px)');
        favList.css('transform', 'translateY(0px)');
        $.ajax({
          url: '/ru/favorites/update-widget.html',
          dataType: 'html',
          success: function(html) {
            favList.replaceWith(html);
            $.initWidgets();

            $('span.product-card__fav[data-id="' + id + '"]').addClass('product-card__fav_active');
            var button = $('button.product-info__btn[data-id="' + id + '"]');
            button.removeClass('btn_red').addClass('product-info__btn_remove').addClass('btn_black');
            button.find('.product-info__btn-text').html('УБРАТЬ ИЗ ИЗБРАННОГО');
          }
        });

        break;
      case 'remove':
        $('div.fav-list__item[data-id="' + id + '"]').remove();
        $('div.saved-list__item[data-id="' + id + '"]').remove();
        $('span.product-card__fav[data-id="' + id + '"]').removeClass('product-card__fav_active');
        var button = $('button.product-info__btn[data-id="' + id + '"]');
        button.removeClass('product-info__btn_remove').removeClass('btn_black').addClass('btn_red');
        button.find('.product-info__btn-text').html('Сохранить товар');
        $.initWidgets();
        break;
    }

    if (json.hasOwnProperty('count')) {
      $('.main-header__fav-count').html(json.count);
      $('.fav-list__count > span').html(json.count);
      $('.fav-page__title > span').html(json.count);
    }
  };

  $('.product-card__fav').click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    var self = $(this);
    var action = !self.hasClass('product-card__fav_active') ? 'add' : 'remove';
    var id = self.data('id');
    $.ajax({
      url: '/ru/favorites/' + action + '.html?id=' + id,
      success: function (json) {
        ajaxSuccess(action, json, id);
      },
      dataType: 'json'
    });

  });

  var clickHandler = ('ontouchstart' in window ? 'touchstart' : 'click');

  $('.product-info__btn').on(clickHandler, function(e) {
    e.preventDefault();
    var self = $(this);
    var action = self.hasClass('product-info__btn_remove') ? 'remove' : 'add';
    var id = self.data('id');
    $.ajax({
      url: '/ru/favorites/' + action + '.html?id=' + id,
      success: function (json) {
        ajaxSuccess(action, json, id);
      },
      dataType: 'json'
    });
  });

  $('.product-card__remove, .saved-list__remove').click(function(e) {
    e.preventDefault();
    var self = $(this);
    var id = self.data('id');
    $.ajax({
      url: self.attr('href'),
      success: function (json) {
        if (json.hasOwnProperty('count')) {
          $('.main-header__fav-count').html(json.count);
          $('.fav-list__count > span').html(json.count);
          $('.fav-page__title > span').html(json.count);
        }

        if (id) {
          $('div.fav-list__item[data-id="' + id + '"]').remove();
          $('div.saved-list__item[data-id="' + id + '"]').remove();
          $('span.product-card__fav[data-id="' + id + '"]').addClass('product-card__fav_active');
          var button = $('button.product-info__btn[data-id="' + id + '"]');
          button.removeClass('product-info__btn_remove').removeClass('btn_black').addClass('btn_red');
          button.find('.product-info__btn-text').html('Сохранить товар');
        }
      },
      dataType: 'json'
    });

  });

})(jQuery);
