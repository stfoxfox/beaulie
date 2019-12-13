/**
 * Created by anatoliypopov on 07.11.15.
 */

$(document).ready(function() {



    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');


        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            type: "POST",
            url: 'save-order.html',
            data: {
                sort_data: window.JSON.stringify(list.nestable('serialize')),
                _csrf: csrfToken
            },
            success: function (json) {


                if (json.error) {
                    swal("Error", "%(", "error");
                }


            },
            dataType: 'json'
        });




    };




// activate Nestable for list 1
    $('#nestable').nestable({
        maxDepth:4,
        handleClass:"dd-h"

    }).on('change', updateOutput);




    $('#createCategory').click(function () {


        swal({

                title: "Добавить категорию",
                text: "Название:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Add",
                cancelButtonText:"Cancel",

                inputPlaceholder: ""
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Title can not be blank");
                    return false   }


                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url:"/catalog/add-category.html",
                    data: {
                        title:inputValue,
                        _csrf : csrfToken

                    },
                    success: function(json){


                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{

                             $('#folder_list li:eq(0)').before(  '<li id="cat_'+json.category_id+'" class="dd-item" data-id="'+json.category_id+'"><a data-cat="'+json.category_id+'" data-cat_name="'+json.category_title+'" class="label label-info pull-right dell-item"  data-dell-url="/catalog/dell.html" data-item-id="'+json.category_id+'" data-item-name="'+json.category_title+'">x</a><div class="dd-handle"><span class="dd-h "><i class="fa fa-list"></i></span>  <a   href="/catalog/'+json.category_id+'.html">'+json.category_title+'</a></div></li>'
                             );
                            swal("Added!", "Spot type category added!", "success");
                        }



                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    });






});
