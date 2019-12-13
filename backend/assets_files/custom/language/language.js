/**
 * Created by anatoliypopov on 19/07/2017.
 */

$(document).ready(function() {


    var change_state_item = function () {

        var lang_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');


        var title = "Подключить язык?";
        if ($(this).data('status')){
            title ="Отключить язык";
        }


        swal({

                title: title,
                text: "" + lang_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ДА",
                cancelButtonText: "НЕТ"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/language/change-status.html",
                    data: {
                        'item_id': item_id,
                        _csrf: csrfToken
                    },
                    success: function (json) {


                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {

                            var button_title= "включить";

                            if(json.status==1){
                                button_title= "выключить";
                            }

                            $("#item_" + json.language_id).html(button_title);

                            swal("Готово!", "\n", "success");
                        }


                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    };



    $('.state').click(change_state_item);






});

