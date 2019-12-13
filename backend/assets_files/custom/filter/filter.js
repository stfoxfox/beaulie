$(document).ready(function() {
  $('#catalogcategoryfilterform-type').on('change', function() {
    var type = parseInt($(this).val());
    console.log(type);
    if (type === 40) {
      $('#field-catalogcategoryfilterform-attribute_id-wrapper').show();
    } else {
      $('#field-catalogcategoryfilterform-attribute_id-wrapper').hide();
      $.ajax({
        type: 'POST',
        url: '/filter/get-view-type.html',
        data: {
          type: type
        },
        success: function(json) {
          if (json.data) {
            var options = '';
            $.each(json.data, function(k, v) {
              options += '<option value="' + k + '">' + v + '</option>';
            });
            $('#catalogcategoryfilterform-view_type').html(options);
          }
        },
        dataType: 'json'
      });
    }
  });

  $('#catalogcategoryfilterform-attribute_id').on('change', function() {
    console.log('Changed');
    $.ajax({
      type: 'POST',
      url: '/filter/get-view-type.html',
      data: {
        attribute_id: $(this).val()
      },
      success: function(json) {
        if (json.data) {
          var options = '';
          $.each(json.data, function(k, v) {
            options += '<option value="' + k + '">' + v + '</option>';
          });
          $('#catalogcategoryfilterform-view_type').html(options);
        }
      },
      dataType: 'json'
    });
  });
});