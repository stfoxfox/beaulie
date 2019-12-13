$(document).ready(function() {
  var $form = $('#quick-filter');
  var submitForm = function($form) {
    var mainFilterQString = window.location.search.substr(1);
    var cid = $form.find('input[name=id]').val();
    var isHome = $form.find('input[name=is_home]').val();
    var url = $form.attr('action') + '?';
    var qString = '';

    $.each($form.find('input[type=checkbox]'), function(key, obj) {
      if ($(obj).is(':checked')) {
        qString += $(obj).attr('name') + '=' + $(obj).val() + '&';
      }
    });
    qString += 'id=' + cid + '&is_home=' + isHome;
    if (mainFilterQString) {
      qString += '&' + mainFilterQString;
    }

    $.ajax({
      type: 'post',
      dataType: 'json',
      url: url + qString,
      success: function(json) {
        $('#collections-count').html(json.count);
        $('#main-catalog').html(json.html);
      }
    });
  };

  $form.find('input[type=checkbox]').on('change', function() {
    submitForm($form);
  });
  $form.find('.filter__clear').on('click', function() {
    $.each($form.find('input[type=checkbox]'), function(key, obj) {
      $(obj).prop('checked', false);
    });
    submitForm($form);
  })
});