(function($) {
  'use strict';

  $('form.main-search').on('submit', function(e) {
    e.preventDefault();

    var q = $(this).find('input[type="text"]').val();
    if (q.length > 2) {
      $.ajax({
        url: '/ru/search.html',
        type: 'POST',
        data: { q: q },
        dataType: 'html',
        success: function(html) {
          $('.main-search__results-wrapper').html(html);
        },
        error: function(xhr,textStatus,err) {
          console.log("readyState: " + xhr.readyState);
          console.log("responseText: "+ xhr.responseText);
          console.log("status: " + xhr.status);
          console.log("text status: " + textStatus);
          console.log("error: " + err);
        }
      });
    }
  });

})(jQuery);